<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageDecryption extends Model
{
    use HasFactory;

    protected $table = 'image_decryption';

    protected $fillable = [
        'uploaded_image',
        'initialization_vector',
        'encryption_key',
        'processed_image',
    ];
}
