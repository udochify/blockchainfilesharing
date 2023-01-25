<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained()->cascadeOnDelete();
            $table->string('file_address');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('owner');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('user_address');
            $table->string('user_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shares');
    }
};
