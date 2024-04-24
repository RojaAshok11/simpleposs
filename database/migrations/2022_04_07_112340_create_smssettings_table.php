<?php

use App\Models\Admin\Auth\User;
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
        Schema::create('smssettings', function (Blueprint $table) {
            $table->id();

            $table->string('provider_name')->unique()->index();
            $table->string('sid')->nullable();
            $table->string('sender_id')->nullable();
            $table->text('token')->nullable();
            $table->string('url')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone_no')->nullable();
            $table->boolean('is_default', array(0, 1))->default(0);

            $table->text('note')->nullable();
            $table->string('sys_id')->unique();
            $table->string('uniqid')->unique();
            $table->uuid('uuid')->unique();
            $table->integer('sequence_id');
            $table->foreignIdFor(User::class);
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->boolean('active', array(0, 1))->default(1);
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
        Schema::dropIfExists('smssettings');
    }
};
