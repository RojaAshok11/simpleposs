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
        Schema::create('amountcds', function (Blueprint $table) {
            $table->id();

            $table->decimal('credit', 10, 2);
            $table->decimal('debit', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->char('c_or_d', 1); // C-Credit D-Debit

            $table->morphs('amountcdable');
            $table->string('note')->nullable();

            $table->foreignIdFor(User::class);
            $table->uuid('uuid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amountcds');
    }
};
