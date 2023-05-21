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

        Schema::create('cameras', function (Blueprint $table) {
            $table->id();
            $table->longText('name')->nullable();
            $table->longText('camera_img')->nullable();
            $table->longText('local_ip');
            $table->longText('local_mask');
            $table->longText('local_gateway');
            $table->longText('users');
            $table->integer('recorder_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cameras');
    }
};
