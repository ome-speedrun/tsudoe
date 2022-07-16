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
        Schema::create('administrator_application', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('application_id');
            $table->foreignUuid('administrator_id');
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreign('administrator_id')->references('id')->on('administrators');
            $table->unique(['application_id', 'administrator_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrator_application');
    }
};
