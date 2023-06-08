<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_decryption', function (Blueprint $table) {
            $table->id();
            $table->text('uploaded_image');
            $table->text('initialization_vector');
            $table->text('encryption_key');
            $table->text('processed_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_decryption');
    }
};
