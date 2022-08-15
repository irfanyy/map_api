<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('layouts', function (Blueprint $table) {
            $table->id();
            $table->integer('row')->unsigned();
            $table->integer('column')->unsigned();
            $table->text('values');
            $table->bigInteger('record_updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // add foreign record updated by 
            // but not neccesserary for test project
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('layouts');
    }
};
