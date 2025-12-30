// database/migrations/2024_01_15_000004_create_activity_logs_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained('users')
                    ->onDelete('cascade');
            $table->string('action'); // created, updated, deleted
            $table->string('model'); // Dokter, Pasien
            $table->unsignedBigInteger('model_id');
            $table->json('changes')->nullable();
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['model', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};