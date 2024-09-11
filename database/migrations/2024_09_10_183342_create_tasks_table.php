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
            $table->string('title', 20);
            $table->string('description');
            $table->date('expirationDate');
            $table->boolean('isActive');
            $table->boolean('isComplete');
            $table->timestamps();
            $table->integer('userCreateId');
            $table->integer('userAssignId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('_tasks');
    }
}
