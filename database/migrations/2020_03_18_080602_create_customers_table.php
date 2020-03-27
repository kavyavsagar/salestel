<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('location')->nullable();
            $table->string('authority_name');
            $table->string('authority_email')->unique();
            $table->string('password')->nullable();
            $table->string('authority_phone');
            $table->string('technical_name');
            $table->string('technical_email')->nullable();
            $table->string('technical_phone');
            $table->integer('refferedby')->default(0);
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
        });

        Schema::create('customer_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->string('document_path');
            $table->boolean('isexpired')->default(0);
        
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            //$table->primary(['customer_id'], 'customer_documents_customer_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customer_documents');
    }
}