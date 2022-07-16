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
        Schema::create('admin_discords', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('discord_id', 20)->unique();
            $table->foreignUuid('administrator_id');
            $table->timestamps();

            $table->foreign('administrator_id')->references('id')->on('administrators');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_discords');
    }
};
