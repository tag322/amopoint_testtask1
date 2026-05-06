<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->string('city');
            $table->string('country')->nullable();
            $table->string('user_agent');
            $table->timestamps();
            
            $table->index('ip');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
