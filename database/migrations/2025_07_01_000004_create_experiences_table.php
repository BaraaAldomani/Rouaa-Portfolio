<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table): void {
            $table->id();
            $table->string('period_ar');
            $table->string('period_en');
            $table->string('role_ar');
            $table->string('role_en');
            $table->string('org_ar');
            $table->string('org_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
