<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('customer_acc_no');
            $table->text('description');
            $table->enum('priority', ['high','medium','low']);
            $table->integer('reported_by');
            $table->string('filepath')->nullable();
            $table->integer('attended_by')->default(0);
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
 
        });

        Schema::create('complaint_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}