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
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid');
            $table->string('uniqid');
            $table->string('name');
            $table->string('trackmsg');
            $table->string('function');
            $table->string('sessionid');
            $table->string('type');
            $table->integer('flag')->default(0);

            $table->morphs('trackable'); //user
            $table->nullableMorphs('functionable'); // function

            $table->softDeletes();
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
        Schema::dropIfExists('trackings');
    }
};
