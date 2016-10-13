<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConsoleInstall extends Migration
{

    private $filename = 'horizontcms.sql';


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try
        {
            $contents = Storage::get($this->filename);

            $contents = str_replace('@__', env('DB_TABLE_PREFIX'), $contents);

            

           /* foreach(File::get($contents) as $query){
               // echo $query;
            }*/

        }
        catch (Illuminate\Filesystem\FileNotFoundException $exception)
        {
            die("The install file doesn't exist");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
