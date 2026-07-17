<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('education_items', function (Blueprint $table): void {
            $table->id();
            $table->string('institution_ar');
            $table->string('institution_en');
            $table->text('detail_ar');
            $table->text('detail_en');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_items');
    }
};
