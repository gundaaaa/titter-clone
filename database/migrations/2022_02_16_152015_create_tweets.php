<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTweets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->default('active');
            $table->string('user_id')->charset('utf8');
            $table->string('user_name')->charset('utf8');
            $table->string('user_nickname')->charset('utf8');
            $table->string('user_image')->charset('utf8');
            $table->text('tweet_body')->charset('utf8');
            $table->string('tweet_image_name')->charset('utf8');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

            // $table->increments('id');
            // $table->string('user_name')->charset('utf8');
            // $table->string('user_nickname')->charset('utf8');
            // $table->string('user_image')->charset('utf8');
            // // tweetする文章⇓
            // $table->text('tweet_body')->charset('utf8');
            // $table->string('tweet_image_name')->charset('utf8');
            // $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
