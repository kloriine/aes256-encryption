<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ImageController extends Controller
{
    public function index() {
        return view('image');
    }

    public function encryption(Request $request) {
        $request->validate([
            'fileUploadOriginal' => 'required|image|mimes:jpeg,png|max:2048',
            'initVectorEncrypt' => 'required',
            'encryptionKey' => 'required',
        ]);
    
        $image = $request->file('fileUploadOriginal');
        $imageData = file_get_contents($image->path());
        $encryptionMethod = 'AES-256-CBC';
        $options = 0;
    
        $encryptionKey = $request->input('encryptionKey');
        $encryptionIV = $request->input('initVectorEncrypt');
    
        $encryptedData = openssl_encrypt($imageData, $encryptionMethod, $encryptionKey, $options, $encryptionIV);
        
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $processedName = 'encrypted_image_' . now()->format('Ymd_His') . '.' . $extension;
    
        $encryptedImagePath = storage_path('app/public/') . $processedName;
        file_put_contents($encryptedImagePath, $encryptedData);
    
        $saveImg = new Image();
        $saveImg->uploaded_image = $originalName;
        $saveImg->initialization_vector = Hash::make($encryptionIV);
        $saveImg->encryption_key = Hash::make($encryptionKey);
        $saveImg->processed_image = $processedName;
        $saveImg->save();
    
        return Response::download($encryptedImagePath, $processedName, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->deleteFileAfterSend(true);
    }

    public function decryption(Request $request) {
        $request->validate([
            'fileUploadDecrypt' => 'required',
            'initVectorDecrypt' => 'required',
            'encryptionKeyDecrypt' => 'required',
        ]);
    
        $image = $request->file('fileUploadDecrypt');
        $imageData = file_get_contents($image->path());
        $encryptionMethod = 'AES-256-CBC';
        $options = 0;
    
        $encryptionKey = $request->input('encryptionKeyDecrypt');
        $encryptionIV = $request->input('initVectorDecrypt');
    
        $decryptedData = openssl_decrypt($imageData, $encryptionMethod, $encryptionKey, $options, $encryptionIV);
        
        $originalName = $image->getClientOriginalName();
        $extension = $image->getClientOriginalExtension();
        $processedName = 'decrypted_image_' . now()->format('Ymd_His') . '.' . $extension;
    
        $decryptedImagePath = storage_path('app/public/') . $processedName;
        file_put_contents($decryptedImagePath, $decryptedData);
    
        $saveImg = new Image();
        $saveImg->uploaded_image = $originalName;
        $saveImg->initialization_vector = Hash::make($encryptionIV);
        $saveImg->encryption_key = Hash::make($encryptionKey);
        $saveImg->processed_image = $processedName;
        $saveImg->save();
    
        return Response::download($decryptedImagePath, $processedName, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->deleteFileAfterSend(true);
    }
}
