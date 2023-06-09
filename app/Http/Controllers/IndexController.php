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
            'secretKeyEncrypt' => 'required',
        ], [
            'initVectorEncrypt.size' => 'The initialization vector must be exactly 16 characters.',
        ]);

        $stringToEncrypt = $request->input('plainTextEncrypt');
        $method = "AES-256-CBC";
        $iv = $request->input('initVectorEncrypt');
        $options = 0;

        $secretKeyEncrypt = $request->input('secretKeyEncrypt');

        $encryptedString = openssl_encrypt($stringToEncrypt, $method, $secretKeyEncrypt, $options, $iv);

        $encryption = new Encryption();
        $encryption->plaintext = hash('sha256', $stringToEncrypt);
        $encryption->initialization_vector = Hash::make($iv);
        $encryption->encryption_key = Hash::make($secretKeyEncrypt);
        $encryption->ciphertext = $encryptedString;
        $encryption->save();

        return redirect()->back()->with([
            'stringToEncrypt' => $stringToEncrypt,
            'secretKeyEncrypt' => $secretKeyEncrypt,
            'ivEnc' => $iv,
            'encryptedString' => $encryptedString,
        ]);
    }

    public function decrypt (Request $request) {
        $request->validate([
            'cipherTextDecrypt' => 'required',
            'initVectorDecrypt' => 'required|size:16',
            'secretKeyDecrypt' => 'required',
        ], [
            'initVectorDecrypt.size' => 'The initialization vector must be exactly 16 characters.',
        ]);

        $stringToDecrypt = $request->input('cipherTextDecrypt');
        $method = "AES-256-CBC";
        $iv = $request->input('initVectorDecrypt');
        $options = 0;

        $secretKeyDecrypt = $request->input('secretKeyDecrypt');

        $decryptedString = openssl_decrypt($stringToDecrypt, $method, $secretKeyDecrypt, $options, $iv);
        
        $decryption = new Decryption();
        $decryption->ciphertext = $stringToDecrypt;
        $decryption->initialization_vector = Hash::make($iv);
        $decryption->encryption_key = Hash::make($secretKeyDecrypt);
        $decryption->plaintext = hash('sha256', $decryptedString); 
        $decryption->save();

        return redirect()->back()->with([
            'stringToDecrypt' => $stringToDecrypt,
            'secretKeyDecrypt' => $secretKeyDecrypt,
            'ivDec' => $iv,
            'decryptedString' => $decryptedString,
        ]);
    }
}
