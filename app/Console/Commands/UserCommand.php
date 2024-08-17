<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class USerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hcms:user {--create-admin} {--name=} {--email=} {--username=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates admin users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }



    public function handle(){

        $this->line("*****Administrator creation*****".PHP_EOL);

        if(!\App\HorizontCMS::isInstalled()){ 
            $this->info("HorizontCMS is not installed!");
            return -1;
        }

        $admin['name'] = empty($this->option("name"))? $this->ask('Name') : $this->option("name");        
        $admin['email'] = empty($this->option("email"))? $this->ask('Email') : $this->option("email") ;
        $admin['username'] = empty($this->option("username"))? $this->ask('Username') : $this->option("username");
        $admin['password'] = empty($this->option("password"))? $this->secret('Password') : $this->option("password");

        try{

            $user = new \App\Model\User();
            $user->name = $admin["name"];
            $user->email = $admin['email'];
            $user->username =  $admin['username'];
            $user->slug = str_slug($admin['username']);
            $user->password = $admin['password'];
            $user->role_id = 6;
            $user->active = 1;

            $user->save();

            $this->info("User ".$user->username." created successfully!");
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }

    }

}