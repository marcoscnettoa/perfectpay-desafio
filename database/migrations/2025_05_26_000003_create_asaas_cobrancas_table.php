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

        Schema::create('asaas_cobrancas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash', 500)->index()->nullable();
            $table->string('asaas_clientes_id', 500)->index()->nullable();
            $table->string('asaas_id', 500)->index()->nullable();
            $table->date('dateCreated')->index()->nullable();
            $table->decimal('value', 20, 2)->nullable();
            $table->decimal('netValue', 20, 2)->nullable();
            $table->string('customer', 500)->index()->nullable();
            $table->string('billingType', 50)->index()->nullable();
            $table->date('dueDate')->index()->nullable();
            $table->date('originalDueDate')->nullable();
            $table->string('status', 200)->index()->nullable();
            $table->string('invoiceUrl', 2000)->nullable();
            $table->string('invoiceNumber', 500)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('externalReference', 2000)->nullable();
            $table->string('bankSlipUrl', 2000)->nullable();
            $table->string('barCode', 500)->nullable();
            $table->text('encodedImage_pixQrCode')->nullable();
            $table->text('payload_pix')->nullable();
            $table->string('cc_holderName', 500)->nullable();
            $table->string('cc_cpfCnpj', 50)->nullable();
            $table->string('cc_number', 50)->nullable();
            $table->string('cc_expiryMonth', 2)->nullable();
            $table->string('cc_expiryYear', 4)->nullable();
            $table->string('cc_ccv', 10)->nullable();
            $table->mediumText('json_request')->nullable();
            $table->mediumText('json_response')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->index()->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asaas_cobrancas');
    }
};
