<?php

use App\Models\Admin\Auth\User;
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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Supplier::class);

            $table->string('supplier_name')->index();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_email')->nullable();

            $table->text('supplier_address');
            $table->string('gst')->nullable();
            $table->string('pan')->nullable();

            $table->date('purchase_date');
            $table->text('note')->nullable();

            $table->double('sub_total', 10, 2)->nullable();
            $table->double('freight_charges', 10, 2)->nullable();
            $table->double('adjustment', 10, 2)->nullable();
            $table->double('discount', 10, 2)->nullable();

            $table->integer('total_items')->nullable();
            $table->double('total', 10, 2)->nullable();
            $table->double('roundoff', 10, 2)->nullable();
            $table->double('grandtotal', 10, 2)->nullable();

            $table->double('taxamt', 10, 2)->nullable();
            $table->double('taxableamt', 10, 2)->nullable();
            $table->double('cgst', 10, 2)->nullable();
            $table->double('sgst', 10, 2)->nullable();
            $table->double('igst', 10, 2)->nullable();
            $table->double('cess', 10, 2)->nullable();
            $table->double('vat', 10, 2)->nullable();

            $table->integer('source_type')->default(1); // 1- Web 2-Mobile 3-Desktop

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
        Schema::dropIfExists('purchases');
    }
};
