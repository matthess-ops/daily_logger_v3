<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('user_id');
            $table->json('questions');
            $table->json('scores');
            $table->string('date_today');

            $table->json('mentor_scores');
            $table->json('mentor_id')->nullable();
            $table->timestamp('filled_at')->nullable();
            $table->timestamp('mentor_filled_at')->nullable();

            $table->boolean('filled')->default(0);
            $table->boolean('mentor_filled')->default(0);
            $table->text('client_remark')->nullable();
            $table->text('mentor_remark')->nullable();
            $table->boolean('started')->default(0);
            $table->boolean('completed')->default(0);
            $table->boolean('mentor_started')->default(0);
            $table->boolean('mentor_completed')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_questions');
    }
}
