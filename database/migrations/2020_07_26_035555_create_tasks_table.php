<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();           
            $table->text('description')->nullable();
            $table->enum('priority', ['high','medium','low']);
            $table->date('start_date')->nullable(); 
            $table->string('start_time')->nullable(); 
            $table->integer('assigned_by');
            $table->integer('status')->default(1);  
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
        Schema::dropIfExists('tasks');
    }
}
