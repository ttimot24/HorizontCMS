<?php

namespace App\Controllers;

use Composer\Semver\Comparator;
use App\Libs\Controller;
use App\Libs\ViewResolver;
use Illuminate\Http\Request;

class UpgradeController extends Controller
{

    private $updateManager = null;

    public function __construct(Request $request,ViewResolver $viewResolver, \Codedge\Updater\UpdaterManager $updater){

        parent::__construct($request, $viewResolver);

        $this->updateManager = $updater;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->show(null);
    }

    public function show($selectedVersion = null){

        $releases = collect($this->updateManager->source()->getReleases()->json());

        $available_list = $releases->filter(fn($release) => Comparator::greaterThan($release['tag_name'], $this->updateManager->source()->getVersionInstalled()));

        $this->view->title(trans('settings.settings'));
        return $this->view->render('upgrade/index', [
            'current_version' => $this->updateManager->source()->getVersionInstalled(),
            'latest_version' => $this->updateManager->source()->getVersionAvailable(),
            'available_list' => $available_list,
            'upgrade_list' => $releases->filter(fn($release) => Comparator::lessThanOrEqualTo($release['tag_name'], $this->updateManager->source()->getVersionInstalled()))->slice(0,5),
            'selected_version' => $selectedVersion? $selectedVersion : $releases->first(fn($release) => $release['tag_name'] === $this->updateManager->source()->getVersionInstalled())
        ]);

    }

    public function update($update)
    {

        $release = $this->updateManager->source()->fetch($update);

        // Run the update process
        $this->updateManager->source()->update($release);

        return redirect(route('upgrade.index'));
    }

 
}
