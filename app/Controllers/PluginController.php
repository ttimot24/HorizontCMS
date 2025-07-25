<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PluginController extends Controller
{


    public function before()
    {
        \File::ensureDirectoryExists('plugins');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('plugin.index', [
            'all_plugin' => collect(\File::directories(base_path() . DIRECTORY_SEPARATOR . "plugins"))->map(function ($dir) {
                return new \App\Model\Plugin(str_replace(base_path() . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR, "", $dir));
            }),
            'zip_enabled' => class_exists('ZipArchive'),
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onlinestore()
    {
        $repo_status = true;

        try {
            $plugins = json_decode(file_get_contents(config('horizontcms.sattelite_url') . '/get_plugins.php'));
        } catch (\ErrorException $e) {
            $plugins = [];
            $repo_status = false;
        }

        return view('plugin.store', ['online_plugins' => $plugins, 'repo_status' => $repo_status]);
    }


    public function downloadPlugin($plugin_name)
    {

        $temp_zip = "framework" . DIRECTORY_SEPARATOR . "temp" . DIRECTORY_SEPARATOR . $plugin_name . ".zip";

        $status = \Storage::disk('local')->put($temp_zip, file_get_contents(\Config::get('horizontcms.sattelite_url') . "/download/plugin/" . $plugin_name));
        chmod(storage_path() . DIRECTORY_SEPARATOR . $temp_zip, 0777);

        if ($status) {

            $zipper = new \Zipper();

            $zipper->make(storage_path() . DIRECTORY_SEPARATOR . $temp_zip)->folder($plugin_name)->extractTo('plugins' . DIRECTORY_SEPARATOR . $plugin_name);

            if (file_exists("plugins/" . $plugin_name)) {
                @\Storage::delete("framework" . DIRECTORY_SEPARATOR . "temp" . DIRECTORY_SEPARATOR . $plugin_name . ".zip");
                return redirect()->back()->withMessage(['success' => trans('Succesfully downloaded ' . $plugin_name)]);
            } else {
                return redirect()->back()->withMessage(['danger' => trans('Could not extract the plugin: ' . $plugin_name . "")]);
            }
        } else {
            return redirect()->back()->withMessage(['danger' => trans('Could not download the plugin: ' . $plugin_name . "")]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $plugin = new \App\Model\Plugin($request->input('plugin'));

            if (!$plugin->isCompatibleWithCore()) {
                return redirect()->back()->withMessage(['warning' => trans('plugin.not_compatible_with_core', ['min_core_ver' => $plugin->getRequiredCoreVersion()])]);
            }


            if ($plugin->getDatabaseFilesPath()) {


                \Artisan::call("migrate", ['--path' => $plugin->getDatabaseFilesPath() . DIRECTORY_SEPARATOR . "migrations", '--no-interaction' => '', '--force' => true]);


                $seed_class = '\\Plugin\\' . $plugin->root_dir . '\\Database\\Seeds\\PluginSeeder';

                if (class_exists($seed_class)) {
                    \Artisan::call('db:seed', ['--class' => $seed_class, '--no-interaction' => '', '--force' => true]);
                }
            }


            $plugin->getRegister('onInstall', []);


            //$plugin->version should be added
            unset($plugin->info, $plugin->config);
            $plugin->area = 0;
            $plugin->permission = 0;
            $plugin->tables = "";
            $plugin->active = 0;


            $plugin->save();

            foreach (\App\Model\UserRole::all() as $role) {
                if ($role->isAdminRole()) {
                    $role->addRight(str_slug($plugin->root_dir));
                    $role->save();
                }
            }

            return redirect()->back()->withMessage(['success' => trans('Succesfully installed ' . $plugin->root_dir)]);
        } catch (\Exception $e) {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong') . " " . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Model\Plugin $plugin)
    {
        $plugin = \App\Model\Plugin::rootDir($request->input('plugin_name'))->firstOrFail();
        $plugin->active = $plugin->active==0? 1 : 0;


        if ($plugin->save()) {
            return redirect()->back()->withMessage(['success' => trans('Succesfully modified ' . $plugin->root_dir)]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    /**
     * Remove the specified resource from database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $plugin)
    {

        try {

            \App\Model\Plugin::rootDir($plugin)->delete();

            if (file_exists("plugins/" . $plugin)) {
                \Storage::disk('plugins')->deleteDirectory($plugin);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong') . " " . $e->getMessage()]);
        }

        return redirect()->back()->withMessage(['success' => trans('Succesfully deleted the plugin!')]);
    }


    public function upload()
    {

        if (request()->hasFile('up_file')) {

            $file_name = request()->up_file[0]->store('framework/temp');
        }

        $zip = new \ZipArchive;
        if ($zip->open("storage/" . $file_name) === TRUE) {
            $zip->extractTo('plugins/');
            $zip->close();

            \Storage::delete("storage/" . $file_name);

            return redirect()->back()->withMessage(['success' => trans('Succesfully uploaded the plugin!')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }
}
