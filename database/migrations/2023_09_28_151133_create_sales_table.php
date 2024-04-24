<?php

use App\Models\Admin\Auth\User;
use App\Models\Admin\Customer\Customer;
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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Customer::class)->nullable();

            $table->string('customer_name')->nullable(); // customer name
            $table->string('customer_phone')->nullable(); // customer phone

            $table->double('sub_total', 10, 2)->nullable();
            $table->double('discount', 10, 2)->nullable();
            $table->double('extra_charges', 10, 2)->nullable();

            $table->double('received_amount', 10, 2)->nullable();
            $table->double('remaining_amount', 10, 2)->nullable();

            $table->integer('total_items')->nullable();
            $table->double('total', 10, 2)->nullable();
            $table->double('roundoff', 10, 2)->nullable();
            $table->double('grandtotal', 10, 2)->nullable();

            $table->double('taxamt', 10, 2)->nullable();
            $table->double('taxableamt', 10, 2)->nullable();
            $table->double('cgst', 10, 2)->nullable();
            $table->double('sgst', 10, 2)->nullable();
            $table->double('vat', 10, 2)->nullable();

            $table->integer('mode')->nullable(); // 1- Cash 2-Card 3-Online
            $table->integer('source_type')->default(1); // 1- Web 2-Mobile 3-Desktop

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
        Schema::dropIfExists('sales');
    }
};
