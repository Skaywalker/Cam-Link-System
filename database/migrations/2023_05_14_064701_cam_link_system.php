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
        Schema::create('recorders', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->longText('serial_number');
            $table->longText('local_ip');
            $table->longText('local_mask');
            $table->longText('local_gateway');
            $table->longText('users');
            $table->longText('channels');
            $table->integer('installer_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recorders');
    }
};
