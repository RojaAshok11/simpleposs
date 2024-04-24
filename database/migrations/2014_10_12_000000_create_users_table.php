<?php

use App\Models\Admin\Auth\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('api_token', 60)->unique()->nullable();
            $table->string('slack', 100)->nullable();

            $table->string('avatar')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('last_sessionid')->nullable();
            $table->integer('role_id');

            $table->text('note')->nullable();
            $table->string('sys_id')->unique();
            $table->string('uniqid')->unique();
            $table->uuid('uuid')->unique();
            $table->integer('sequence_id');
            $table->foreignIdFor(User::class)->nullable();
            $table->unsignedBigInteger('updated_id')->nullable();
            $table->boolean('is_accountactive', array(0, 1))->default(1);

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
