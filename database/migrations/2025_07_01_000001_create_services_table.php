<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('icon')->default('');
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('summary_ar');
            $table->text('summary_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->json('features_ar')->nullable();
            $table->json('features_en')->nullable();
            $table->text('legal_note_ar')->nullable();
            $table->text('legal_note_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
