<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_series', function (Blueprint $table): void {
            $table->id();
            $table->string('title_ar');
            $table->string('title_en');
            $table->string('tag_ar')->default('');
            $table->string('tag_en')->default('');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_series');
    }
};
