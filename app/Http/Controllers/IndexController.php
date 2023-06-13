<?php

namespace App\Http\Controllers;

use App\Models\Decryption;
use App\Models\Encryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    public function index () {
        return view('index');
    }

    public function encryption(Request $request) {
        $request->validate([
            'fileUploadOriginal' => 'required',
            'initVectorEncrypt' => 'required|size:16',
            'secretKeyEncrypt' => 'required',
        ], [
            'initVectorEncrypt.size' => 'The initialization vector must be exactly 16 characters.',
        ]);
    
        $file = $request->file('fileUploadOriginal');
        $fileData = file_get_contents($file->path());
        $encryptionMethod = 'AES-256-CBC';
        $options = 0;
    
        $secretKeyEncrypt = $request->input('secretKeyEncrypt');
        $encryptionIV = $request->input('initVectorEncrypt');
    
        $encryptedData = openssl_encrypt($fileData, $encryptionMethod, $secretKeyEncrypt, $options, $encryptionIV);
        
        $extension = $file->getClientOriginalExtension();
        $uploadedName = 'original_file_' . now()->format('Ymd_His') . '.' . $extension;
        $processedName = 'encrypted_file_' . now()->format('Ymd_His') . '.' . $extension;
    
        $encryptedFilePath = storage_path('app/public/') . $processedName;
        file_put_contents($encryptedFilePath, $encryptedData);
    
        $saveFile = new Encryption();
        $saveFile->uploaded_file = $uploadedName;
        $saveFile->initialization_vector = Hash::make($encryptionIV);
        $saveFile->encryption_key = Hash::make($secretKeyEncrypt);
        $saveFile->processed_file = $processedName;
        $saveFile->save();
    
        return Response::download($encryptedFilePath, $processedName, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->deleteFileAfterSend(true);
    }

    public function decryption(Request $request) {
        $request->validate([
            'fileUploadDecrypt' => 'required',
            'initVectorDecrypt' => 'required|size:16',
            'secretKeyDecrypt' => 'required',
        ], [
            'initVectorDecrypt.size' => 'The initialization vector must be exactly 16 characters.',
        ]);
    
        $file = $request->file('fileUploadDecrypt');
        $fileData = file_get_contents($file->path());
        $encryptionMethod = 'AES-256-CBC';
        $options = 0;
    
        $secretKeyDecrypt = $request->input('secretKeyDecrypt');
        $encryptionIV = $request->input('initVectorDecrypt');
    
        $decryptedData = openssl_decrypt($fileData, $encryptionMethod, $secretKeyDecrypt, $options, $encryptionIV);
        
        $extension = $file->getClientOriginalExtension();
        $uploadedName = $file->getClientOriginalName();
        $processedName = 'decrypted_file_' . now()->format('Ymd_His') . '.' . $extension;
    
        $decryptedFilePath = storage_path('app/public/') . $processedName;
        file_put_contents($decryptedFilePath, $decryptedData);
    
        $saveFile = new Decryption();
        $saveFile->uploaded_file = $uploadedName;
        $saveFile->initialization_vector = Hash::make($encryptionIV);
        $saveFile->encryption_key = Hash::make($secretKeyDecrypt);
        $saveFile->processed_file = $processedName;
        $saveFile->save();
    
        return Response::download($decryptedFilePath, $processedName, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->deleteFileAfterSend(true);
    }
}
