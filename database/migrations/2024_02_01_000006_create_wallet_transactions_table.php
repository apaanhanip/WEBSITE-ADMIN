<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['topup', 'purchase', 'refund']);
            $table->decimal('amount', 12, 2); // signed: + for topup/refund, - for purchase
            $table->decimal('balance_after', 12, 2);
            $table->string('method')->nullable(); // promptpay, truewallet, bank, etc.
            $table->string('reference')->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['success', 'pending'])->default('success');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
