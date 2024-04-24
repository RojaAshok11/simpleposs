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
        Schema::create('emailsettings', function (Blueprint $table) {
            $table->id();

            $table->string('provider_name')->unique()->index();
            $table->string('email_from_name')->nullable();
            $table->string('email_from_mail');
            $table->string('email_mail_driver')->nullable();
            $table->string('email_mail_host')->nullable();
            $table->string('email_mail_port')->nullable();
            $table->string('email_mail_username')->nullable();
            $table->string('email_mail_password')->nullable();
            $table->string('email_mail_encryption')->nullable();
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
        Schema::dropIfExists('emailsettings');
    }
};
