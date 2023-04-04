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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('device');
            $table->string('browser');
            $table->string('browser_v');
            $table->string('platform');
            $table->string('platform_v');
            $table->boolean('isrobot');
            $table->boolean('isdesktop');
            $table->boolean('istablet');
            $table->boolean('isphone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
