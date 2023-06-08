<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageEncryption extends Model
{
    use HasFactory;

    protected $table = 'image_encryption';

    protected $fillable = [
        'uploaded_image',
        'initialization_vector',
        'encryption_key',
        'processed_image',
    ];
}
