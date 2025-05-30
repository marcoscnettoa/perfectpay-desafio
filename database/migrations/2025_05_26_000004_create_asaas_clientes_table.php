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

        Schema::create('asaas_clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('asaas_id', 500)->nullable()->index();
            $table->date('asaas_dateCreated')->nullable();
            $table->string('name', 500)->nullable()->index();
            $table->string('email', 500)->nullable()->index();
            $table->string('company', 500)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('mobilePhone', 50)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('addressNumber', 500)->nullable();
            $table->string('complement', 500)->nullable();
            $table->string('province', 500)->nullable();
            $table->string('postalCode', 500)->nullable()->index();
            $table->string('cpfCnpj', 50)->nullable();
            $table->string('personType', 50)->nullable()->index();
            $table->string('city', 100)->nullable();
            $table->string('cityName', 500)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 500)->nullable();
            $table->text('observations')->nullable();
            $table->string('cc_holderName', 500)->nullable();
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
        Schema::dropIfExists('asaas_clientes');
    }
};
