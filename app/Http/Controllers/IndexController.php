<?php

namespace App\Http\Controllers;

use App\Models\Decryption;
use App\Models\Encryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index () {
        return view('index');
    }

    public function encrypt (Request $request) {
        $request->validate([
            'plainTextEncrypt' => 'required',
            'initVectorEncrypt' => 'required|size:16',
            'encryptionKey' => 'required',
        ], [
            'initVectorEncrypt.size' => 'The initialization vector must be exactly 16 characters.',
        ]);

        $stringToEncrypt = $request->input('plainTextEncrypt');
        $method = "AES-256-CBC";
        $iv = $request->input('initVectorEncrypt');
        $options = 0;

        $encryptionKey = $request->input('encryptionKey');

        $encryptedString = openssl_encrypt($stringToEncrypt, $method, $encryptionKey, $options, $iv);

        $encryption = new Encryption();
        $encryption->plaintext = hash('sha256', $stringToEncrypt);
        $encryption->initialization_vector = Hash::make($iv);
        $encryption->encryption_key = Hash::make($encryptionKey);
        $encryption->ciphertext = $encryptedString;
        $encryption->save();

        return redirect()->back()->with([
            'stringToEncrypt' => $stringToEncrypt,
            'encryptionKey' => $encryptionKey,
            'ivEnc' => $iv,
            'encryptedString' => $encryptedString,
        ]);
    }

    public function decrypt (Request $request) {
        $request->validate([
            'cipherTextDecrypt' => 'required',
            'initVectorDecrypt' => 'required|size:16',
            'encryptionKeyDecrypt' => 'required',
        ], [
            'initVectorDecrypt.size' => 'The initialization vector must be exactly 16 characters.',
        ]);

        $stringToDecrypt = $request->input('cipherTextDecrypt');
        $method = "AES-256-CBC";
        $iv = $request->input('initVectorDecrypt');
        $options = 0;

        $encryptionKey = $request->input('encryptionKeyDecrypt');

        $decryptedString = openssl_decrypt($stringToDecrypt, $method, $encryptionKey, $options, $iv);
        
        $decryption = new Decryption();
        $decryption->ciphertext = $stringToDecrypt;
        $decryption->initialization_vector = Hash::make($iv);
        $decryption->encryption_key = Hash::make($encryptionKey);
        $decryption->plaintext = hash('sha256', $decryptedString); 
        $decryption->save();

        return redirect()->back()->with([
            'stringToDecrypt' => $stringToDecrypt,
            'encryptionKeyDec' => $encryptionKey,
            'ivDec' => $iv,
            'decryptedString' => $decryptedString,
        ]);
    }
}
