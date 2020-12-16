<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');            
            $table->enum('plan_type', ['fixed', 'mobile']);
            $table->integer('total_amount')->default(0);
            $table->integer('order_status_id')->default(0);
            $table->date('activation_date')->nullable();  
            $table->timestamps();
            
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });

        Schema::create('order_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->integer('order_status_id');
            $table->text('comments')->nullable();
            $table->string('activity_no')->nullable();            
            $table->integer('added_by');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });

        Schema::create('order_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->integer('price');
            $table->string('plan');
            $table->integer('plan_id');
            $table->enum('plan_type', ['New', 'MRV', 'Migrated']);                     
            $table->integer('quantity')->default(0);
            $table->integer('total')->default(0);
            $table->text('phoneno')->nullable(); 
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_histories');
        Schema::dropIfExists('order_plans');
    }
}