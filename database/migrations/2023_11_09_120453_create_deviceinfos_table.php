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
        Schema::create('deviceinfos', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->nullable();

            $table->string('device_token')->nullable();
            $table->string('device_model')->nullable();
            $table->string('device_brand')->nullable();
            $table->string('device_manufacturer')->nullable();

            $table->string('computer_name')->nullable();

            $table->string('no_of_cores')->nullable();
            $table->string('user_name')->nullable();
            $table->string('editionid')->nullable();
            $table->string('productid')->nullable();
            $table->string('product_name')->nullable();
            $table->string('register_owner')->nullable();
            $table->string('deviceid')->nullable();

            $table->string('host_name')->nullable();
            $table->string('arch')->nullable();
            $table->string('kernel_version')->nullable();
            $table->string('major_version')->nullable();
            $table->string('minor_version')->nullable();
            $table->string('patch_version')->nullable();
            $table->string('os_release')->nullable();
            $table->string('active_cpus')->nullable();
            $table->string('memory_size')->nullable();
            $table->string('cpu_frequency')->nullable();
            $table->string('system_guid')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deviceinfos');
    }
};
