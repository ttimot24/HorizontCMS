<?php

namespace App\Controllers;

use Composer\Semver\Comparator;
use App\Libs\Controller;

class UpgradeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Codedge\Updater\UpdaterManager $updater)
    {

        $releases = collect($updater->source()->getReleases()->json());

        $this->view->title(trans('settings.settings'));
        return $this->view->render('upgrade/index', [
            'current_version' => $updater->source()->getVersionInstalled(),
            'latest_version' => $updater->source()->getVersionAvailable(),
            'available_list' => $releases->filter(fn($release) => Comparator::greaterThan($release['tag_name'], $updater->source()->getVersionAvailable())),
            'upgrade_list' => $releases->filter(fn($release) => Comparator::lessThanOrEqualTo($release['tag_name'], $updater->source()->getVersionAvailable()))->slice(0,5),
        ]);

    }

    public function update(\Codedge\Updater\UpdaterManager $updater)
    {

    }

 
}
