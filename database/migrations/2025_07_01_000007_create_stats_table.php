<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stats', function (Blueprint $table): void {
            $table->id();
            $table->string('context')->default('hero'); // hero | banner
            $table->string('value_display');            // e.g. "+80", "1K+"
            $table->unsignedInteger('counter_target')->default(0); // numeric target for count-up
            $table->string('label_ar');
            $table->string('label_en');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('context');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stats');
    }
};
