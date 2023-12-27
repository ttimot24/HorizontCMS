<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Libs\Controller;

use App\Model\Settings;
use \VisualAppeal\AutoUpdate;
use \Jackiedo\LogReader\Facades\LogReader;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{

    public function before()
    {
        if (!file_exists("storage/images/logos")) {
            File::makeDirectory("storage/images/logos", $mode = 0777, true, true);
        }

        if (!file_exists("storage/images/favicons")) {
            File::makeDirectory("storage/images/favicons", $mode = 0777, true, true);
        }
    }


    public function store(Request $request)
    {

        foreach ($request->all() as $key => $value) {
            Settings::updateOrCreate(['setting' => $key], ['value' => $value, 'more' => 1]);
        }

        return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
    }

    private function getSettingsPanels()
    {


        return [
            ['name' => trans('settings.website'), 'link' => route('settings.show', ['setting' => 'website']), 'icon' => 'fa fa-globe'],
            ['name' => trans('settings.admin_area'), 'link' => route('settings.show', ['setting' => 'adminarea']), 'icon' => 'fa fa-desktop'],
            ['name' => trans('settings.update_center'), 'link' => route('settings.show', ['setting' => 'updatecenter']), 'icon' => 'fa fa-arrow-circle-o-up'],
            ['name' => trans('settings.server'), 'link' => route('settings.show', ['setting' => 'server']), 'icon' => 'fa fa-server'],
            ['name' => trans('settings.social_media'), 'link' => route('settings.show', ['setting' => 'socialmedia']), 'icon' => 'fa fa-thumbs-o-up'],
            ['name' => trans('Log'), 'link' => route('settings.show', ['setting' => 'log']), 'icon' => 'fa fa-bug'],
            ['name' => trans('settings.database'), 'link' => route('settings.show', ['setting' => 'database']), 'icon' => 'fa fa-database'],
            ['name' => trans('settings.scheduler'), 'link' => route('settings.show', ['setting' => 'schedules']), 'icon' => 'fa fa-clock-o'],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/index', [
            'panels' => $this->getSettingsPanels(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->{$id}();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function website()
    {


        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/website', [
            'available_logos' => array_slice(scandir("storage/images/logos"), 2),
            'user_roles' => \App\Model\UserRole::all(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adminarea()
    {


        $this->view->title(trans('settings.settings'));
        return $this->view->render('settings/adminarea', [
            'languages' => ['en' => 'English', 'hu' => 'Magyar'],
            'available_logos' => array_slice(scandir("storage/images/logos"), 2),
            'dateFormats' => ['Y.m.d H:i:s', 'Y-m-d H:i:s', 'Y. M. d H:i:s', 'd-m-Y H:i:s', 'd/m/Y H:i:s', 'm/d/Y H:i:s'],
        ]);
    }


    public function sysUpgrade()
    {

        $echo = array();

        $workspace = storage_path("framework/upgrade");
        $url = \Config::get('horizontcms.sattelite_url') . "/updates";


        $update = new AutoUpdate($workspace . '/temp', public_path(), 60);
        $update->setCurrentVersion(\App\Model\SystemUpgrade::getCurrentVersion()->version);
        $update->setUpdateUrl($url); //Replace with your server update directory
        // Optional:
        $update->addLogHandler(new \Monolog\Handler\StreamHandler($workspace . '/update.log'));
        $update->setCache(new \Desarrolla2\Cache\File($workspace . '/cache'), 3600);
        //Check for a new update


        if ($update->checkUpdate() === false) {
            $echo[] = 'Could not check for updates! See log file for details.';
        } else {
            if ($update->newVersionAvailable()) {
                //Install new update
                $echo[] =  'New Version: ' . $update->getLatestVersion() . '<br>';
                $echo[] =  'Installing Updates: <br>';
                $echo[] =  '<pre>';
                $echo[] = print_r(array_map(function ($version) {
                    return (string) $version;
                }, $update->getVersionsToUpdate()), true);
                $echo[] =  '</pre>';
                // This call will only simulate an update.
                // Set the first argument (simulate) to "false" to install the update
                // i.e. $update->update(false);
                $result = $update->update(false);
                if ($result === true) {
                    $echo[] = 'Update successful<br>';
                    $sys_upgrade = new \App\Model\SystemUpgrade();
                    $sys_upgrade->version = $update->getLatestVersion();
                    $sys_upgrade->nickname = "Upgrade";
                    $sys_upgrade->importance = "important";
                    $sys_upgrade->description = "It was a successful update!";
                    $sys_upgrade->save();

                    \Artisan::call("migrate", ['--no-interaction' => '', '--force' => true]);
                } else {
                    $echo[] = 'Update failed: ' . $result . '!<br>';
                    if ($result = AutoUpdate::ERROR_SIMULATE) {
                        $echo[] = '<pre>';
                        $echo[] = print_r($update->getSimulationResults(), true);
                        $echo[] = '</pre>';
                    }
                }
            } else {
                $echo[] = 'Current Version is up to date<br>';
            }
        }
        $echo[] = 'Log:<br>';
        $echo[] = nl2br(file_get_contents($workspace . '/update.log'));


        return $this->redirectToSelf()->with(['upgrade_console' => implode("<br>", $echo)]);
    }



    public function server()
    {
        $this->view->title("Server");
        return $this->view->render('settings/server', [
            'server' => $this->request->server(),
        ]);
    }


    public function database()
    {

        switch (\Config::get('database.default')) {

            case 'mysql':
                $tables = \DB::select('SHOW TABLES');
                break;
            case 'pgsql':
                $tables = \DB::select('SELECT table_name FROM information_schema.tables ORDER BY table_name');
                break;
            case 'sqlite':
                $tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
                break;

            default:
                $tables = [['name' => 'Could not get table informations']];
        }

        $this->view->title(trans('settings.database'));
        return $this->view->render('settings/database', [
            'tables' =>  $tables,

        ]);
    }



    public function socialmedia()
    {


        if ($this->request->isMethod('POST')) {

            foreach ($this->request->all() as $key => $value) {
                Settings::where('setting', '=', "social_link_" . $key)->update(['value' => $value]);
            }

            return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_saved_settings')]);
        }

        $this->view->title("SocialMedia");
        return $this->view->render('settings/socialmedia', [
            'all_socialmedia' => \SocialLink::all(),
        ]);
    }



    public function log($file = null)
    {

        LogReader::setLogPath(dirname(\Config::get('logging.channels.' . \Config::get('logging.default') . '.path')));

        $entries = collect();
        $files = collect(LogReader::getLogFilenameList());

        if ($files->isNotEmpty()) {

            $current_file = (isset($file) && $file != "" && $file != NULL) ? $file : basename($files->last());

            $entries = LogReader::filename($current_file)->get();
        }

        // dd($entries);

        $this->view->title("Log files");
        return $this->view->render('settings/log', [
            'all_files' => $files->reverse(),
            'entries' => $entries->reverse(),
            'entry_number' => $entries->count(),
            'all_file_entries' => LogReader::count(),
            'current_file' => isset($current_file) ? $current_file : null,
            'max_files' => 15
        ]);
    }


    public function schedules()
    {


        $this->view->title("Schedules");
        return $this->view->render('settings/schedules', [
            'commands' => \Artisan::all(),
            'scheduled_tasks' => \App\Model\ScheduledTask::all(),
        ]);
    }
}
