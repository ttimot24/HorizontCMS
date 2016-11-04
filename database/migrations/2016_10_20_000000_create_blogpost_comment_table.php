<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogpostCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogpost_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blogpost_id');
            $table->integer('user_id');
            $table->text('comment');
            $table->timestamps();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blogpost_comments');
    }
}
