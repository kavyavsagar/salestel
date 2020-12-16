<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('dsrs', function (Blueprint $table) {
            $table->id();
            $table->string('company');
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('location')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('dsr_status');
            $table->integer('refferedby')->default(0);
            $table->date('reminder_date')->nullable();
            $table->timestamps();
        });

        Schema::create('dsr_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dsr_id');
            $table->integer('price');
            $table->string('plan');
            $table->string('plan_type');                   
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->foreign('dsr_id')
                ->references('id')
                ->on('dsr')
                ->onDelete('cascade');
        });

        Schema::create('dsr_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dsr');
        Schema::dropIfExists('dsr_plans');
        Schema::dropIfExists('dsr_statuses');
    }
}
