<?php

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
        Schema::create('transaction_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organisation_id');
            $table->foreignUuid('bank_account_id');
            $table->foreignUuid('user_id');
            $table->dateTime('transaction_date');
            $table->enum('type', ['deposit', 'withdrawal', 'other']);
            $table->unsignedInteger('amount'); // please change to decimal if necessary
            $table->string('purpose')->nullable();
            $table->text('note')->nullable();
            $table->date('payment_due_date')->nullable(); // only used for withdrawal
            $table->boolean('paid')->nullable(); // only used for withdrawal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_records');
    }
};
