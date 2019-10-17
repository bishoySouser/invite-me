<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('invitee_id');
            $table->string('subject');
            $table->text('description');
            $table->date('date_meeting');
            $table->time('start_time');
            $table->time('finish_time')->nullable();
            $table->enum('status', ['pending', 'change time', 'approved']);
            $table->integer('do_order'); // who did order 
            $table->timestamps();
            // 'owner' field referenced the 'id' field of 'users' table:
            $table->foreign('owner_id')
                  ->references('id')
                  ->on('users');
            // 'invitee' field referenced the 'id' field of 'users' table:
            $table->foreign('invitee_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
