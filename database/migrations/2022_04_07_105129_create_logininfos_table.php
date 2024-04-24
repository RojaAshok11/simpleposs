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
        Schema::create('logininfos', function (Blueprint $table) {
            $table->id('id');

            $table->uuid('uuid');
            $table->string('device')->nullable();
            $table->string('robot')->nullable();
            $table->string('browser')->index('browser')->nullable();
            $table->string('browser_v')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_v')->nullable();
            $table->string('serverIp')->nullable();
            $table->string('clientIp')->nullable();
            $table->string('languages')->nullable();
            $table->string('regexp')->nullable();
            $table->string('sessionid');
            $table->string('email')->nullable();
            $table->string('type');
            $table->boolean('login_status', array(0, 1))->default(1);
            $table->integer('flag')->default(0);

            $table->morphs('logininfoable');

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
        Schema::dropIfExists('logininfos');
    }
};
