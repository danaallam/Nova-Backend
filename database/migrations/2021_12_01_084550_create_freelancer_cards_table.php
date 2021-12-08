<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancerCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_cards', function (Blueprint $table) {
            $table->id();
            $table->string('resume');
            $table->string('coverLetter')->nullable();
            $table->boolean('accepted');
            $table->bigInteger('freelancer_id');
            $table->bigInteger('card_id');
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
        Schema::dropIfExists('freelancer_cards');
    }
}
