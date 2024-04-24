<?php

use App\Models\Admin\Auth\User;
use App\Models\Admin\Purchase\Purchase;
use App\Models\Admin\Supplier\Supplier;
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
        Schema::create('purchasereturns', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Supplier::class);
            $table->foreignIdFor(Purchase::class);
            $table->string('supplier_name')->index();
            $table->string('supplier_phone')->nullable();

            $table->text('issue_note')->nullable();
            $table->double('grand_total', 10, 2);
            $table->double('round_off', 10, 2)->nullable();
            $table->integer('source_type')->nullable()->default(1); // 1- Web 2-Mobile 3-Desktop

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
     */
    public function down(): void
    {
        Schema::dropIfExists('purchasereturns');
    }
};
