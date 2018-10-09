<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizontcms:install {--driver=} {--database=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting up the database relations for  HorizontCMS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "
 _  _         _            _    ___ __  __ ___    ___ _    ___ 
| || |___ _ _(_)______ _ _| |_ / __|  \/  / __|  / __| |  |_ _|
| __ / _ \ '_| |_ / _ \ ' \  _| (__| |\/| \__ \ | (__| |__ | | 
|_||_\___/_| |_/__\___/_||_\__|\___|_|  |_|___/  \___|____|___|
                                                                
        ";

echo "\r\n-------------------------------------------------------------------\r\n";

if(\App\HorizontCMS::isInstalled()){
    $this->info("\r\nAlready installed!");
    $continue = $this->choice("Do you want to reinstall?",['yes','no'],1);
    if($continue==="no"){
        $this->info("Quit installer");
        return;
    }
}

$this->line("*****Database informations*****\r\n");
$database['username'] = $this->ask('Username');
$database['password'] = $this->ask('Password',false);

if ($database['password'] === FALSE){ 
	$database['password'] = "";
}

 if($this->option('driver')!=""){
    $database['driver'] = $this->option('driver');
 }
 else{
    $database['driver'] = $this->choice('Database driver', array_keys(\Config::get('database.connections')), 0);
 }

if($this->option('database')!=""){
    $database['database'] = $this->option('database');
}else{
    $database['database'] =  $this->ask('Database');
}

$this->line("Selected database driver: ".$database['driver']." \r\n");

$this->line("Selected database: ".$database['database']." \r\n");


$this->line("*****Administrator informations*****\r\n");
$admin['username'] = $this->ask('Username');
$admin['password'] = $this->secret('Password');
$admin['email'] = $this->ask('Email');

$this->info("1. Generating .env file");

$dotenv = new \App\Libs\DotEnvGenerator();
$dotenv->addEnvVar('DB_HOST','127.0.0.1');
$dotenv->addEnvVar('DB_PORT','3306');
$dotenv->addEnvVar('DB_CONNECTION',$database['driver']);
$dotenv->addEnvVar('DB_USERNAME',$database['username']);
$dotenv->addEnvVar('DB_PASSWORD',$database['password']);
$dotenv->addEnvVar('DB_DATABASE',$database['database']);

$dotenv->addEnvVar('HCMS_ADMIN_PREFIX','admin');
$dotenv->generate();

\Artisan::call("cache:clear");

\Config::set('database.connections.'.$database['driver'].'.username', $database['username']);
\Config::set('database.connections.'.$database['driver'].'.password', $database['password']);
\Config::set('database.connections.'.$database['driver'].'.database', $database['database']);

$this->info("Ready");

$this->info("2. Migrating the database. [press 'y']");
	\Artisan::call("migrate");
$this->info("Ready");
$this->info("3. Seeding the database. [press 'y']");
	\Artisan::call("db:seed");
$this->info("Ready");

$administrator = new \App\Model\User();
$administrator->name = 'Administrator';
$administrator->username = $admin['username'];
$administrator->slug = str_slug($admin['username']);
$administrator->password = $admin['password'];
$administrator->email = $admin['email'];
$administrator->role_id = 6;

if(!$administrator->save()){
	$this->error("Could not create admin user!");
}



$systemupgrade = new \App\Model\SystemUpgrade();
$systemupgrade->version = \Config::get('horizontcms.version');
$systemupgrade->nickname = "Core";
$systemupgrade->importance = "most important";
$systemupgrade->description = "welcome!";

$systemupgrade->save();

\Artisan::call("key:generate");

$this->info("\r\nHorizontCMS successfully installed!\r\n");

    }
}
