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
        Schema::create('account_parcels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('value', 10, 2);
            $table->date('due_date'); //vencimento
            $table->date('payment')->nullable(); //pagamento
            $table->char('payment_status',1)->default(0); //pagamento status
            $table->decimal('payment_interest', 10,2)->nullable(); //juros
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
            $table->foreign('account_id')
                ->references('id')
                ->on('accounts');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_parcels');
    }
};
