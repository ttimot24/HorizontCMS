<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Services\Theme;
use App\Model\Settings;

class ThemeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view("theme.index", [
            'active_theme' => new Theme($request->settings['theme']),
            'all_themes' => collect(array_slice(scandir("themes"), 2))->map(function ($theme) {
                return new Theme($theme);
            })
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
     * Display config page.
     *
     * @return \Illuminate\Http\Response
     */
    public function config($slug)
    {

        $websiteController = new \App\Controllers\WebsiteController(request());
        $websiteController->before();

        $theme_engine = new \App\Services\ThemeEngine(request());
        $theme_engine->setTheme(new Theme(request()->settings['theme']));

        $theme_engine->boot();

        \Website::initalize($theme_engine);

        return view("theme.config", [
            'active_theme' => new Theme(request()->settings['theme']),
            'website_content' => $websiteController->index(request()->input('page')),
        ]);
    }


    public function options($theme)
    {

        if (!Settings::has('custom_css_' . snake_case($theme))) {
            $theme_css = new Settings();
            $theme_css->setting = 'custom_css_' . snake_case($theme);
            $theme_css->value = "";
            $theme_css->more = 1;
            $theme_css->save();
        }

        $theme = new Theme($theme == null ? request()->settings['theme'] : $theme);

        $translations = [];

        foreach ($theme->getSupportedLanguages() as $lang) {
            $translations[$lang] = json_decode(file_get_contents($theme->getPath() . $theme->languagePath . "/" . $lang . ".json"));
        }

        return view('theme.options', ['option' => empty(request()->input('option')) ? 'style' : request()->input('option'), 'translations' => $translations, 'theme' => $theme->root_dir, 'settings' => request()->settings]);
    }

    public function updateTranslations($theme)
    {

        if (request()->isMethod('POST')) {

            try {
                $theme = new Theme($theme == null ? request()->settings['theme'] : $theme);

                $translations = [];

                foreach ($theme->getSupportedLanguages() as $lang) {

                    file_put_contents($theme->getPath() . "lang/" . $lang . ".json", json_encode(request()->input($lang, new \stdClass())));
                }

                return redirect()->back()->withMessage(['success' => trans('message.successfully_saved_settings')]);
            } catch (\Exception $e) {
                \Log::error($e);
                return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function set($theme)
    {

        if (Settings::where('setting', 'theme')->update(['value' => $theme])) {
            return redirect()->back()->withMessage(['success' => trans('message.successfully_changed_theme')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->hasFile('up_file')) {

            $file_name = $request->up_file[0]->store('framework/temp');
        }

        $zip = new \ZipArchive;
        if ($zip->open("storage/" . $file_name) === TRUE) {
            $zip->extractTo('themes/');
            $zip->close();

            \Storage::delete("storage/" . $file_name);

            return redirect()->back()->withMessage(['success' => trans('Succesfully uploaded the theme!')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }


    public function destroy($theme)
    {

        if (\File::deleteDirectory("themes/" . $theme)) {
            return redirect()->back()->withMessage(['success' => trans('Succesfully deleted the theme!')]);
        } else {
            return redirect()->back()->withMessage(['danger' => trans('message.something_went_wrong')]);
        }
    }

    public function onlinestore()
    {
        $repo_status = true;

        try {

            $themes = json_decode(file_get_contents(\Config::get('horizontcms.sattelite_url') . '/get_themes.php'));

            if ($themes == null) {
                throw ErrorException('Could not fetch Themes');
            }
        } catch (\ErrorException $e) {
            $themes = [];
            $repo_status = false;
        }

        return view('theme.store', ['online_themes' => $themes, 'repo_status' => $repo_status]);
    }
}
