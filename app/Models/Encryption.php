<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encryption extends Model
{
    use HasFactory;

    protected $table = 'encryption';

    protected $fillable = [
        'uploaded_file',
        'initialization_vector',
        'encryption_key',
        'processed_file',
    ];
}
