<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_name = 'pages';
    
    public function up()
    {
        if (Schema::hasTable($this->table_name)) { return; }

        Schema::create($this->table_name, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('url');
            $table->integer('visibility');
            $table->integer('parent_id')->nullable();
            $table->integer('queue');
            $table->text('page');
            $table->integer('author_id');
            $table->string('image')->nullable();
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
        Schema::drop($this->table_name);
    }
}
