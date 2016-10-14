<?php

namespace App\Http\Middleware;

use Closure;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        \Menu::make('MainMenu', function($menu) {

            $prefix = \Config::get('horizontcms.backend_prefix');


            $menu->add(trans('navbar.dashboard'), $prefix."/dashboard");

            $menu->add(trans('navbar.news'), '#');
            $menu->item(strtolower(trans('navbar.news')))->add(trans('navbar.posted_news'), $prefix."/blogpost");
            $menu->item(strtolower(trans('navbar.news')))->add(trans('navbar.create_post'), $prefix."/blogpost/create");
            $menu->item(strtolower(trans('navbar.news')))->add(trans('navbar.categories'), $prefix.'/categories');


            $menu->add(trans('navbar.users'), '#');
            $menu->item(strtolower(trans('navbar.users')))->add(trans('navbar.user_list'), $prefix.'/users');
            $menu->item(strtolower(trans('navbar.users')))->add(trans('navbar.user_add'), $prefix.'/users/create');
            $menu->item(strtolower(trans('navbar.users')))->add(trans('navbar.user_groups'), $prefix.'/usergroups');



            $menu->add(trans('navbar.pages'), '#');
            $menu->item(strtolower(trans('navbar.pages')))->add(trans('navbar.page_list'), $prefix.'/page');
            $menu->item(strtolower(trans('navbar.pages')))->add(trans('navbar.page_add'), $prefix.'/page/create');
            
            $menu->add(trans('navbar.media'), '#');
            $menu->item(strtolower(trans('navbar.media')))->add(trans('navbar.header_images'), $prefix.'/headerimage');
            $menu->item(strtolower(trans('navbar.media')))->add(trans('navbar.filemanager'), $prefix.'/filemanager');
            $menu->item(strtolower(trans('navbar.media')))->add(trans('navbar.gallery'), $prefix.'/gallery');
            
            
            $menu->add(trans('navbar.themes_apps'), '#');
        /*    $menu->item(strtolower(trans('navbar.themes_apps')))->add(trans('navbar.theme'), $prefix.'/theme');
            $menu->item(strtolower(trans('navbar.themes_apps')))->add(trans('navbar.plugin'), $prefix.'/plugin');
            $menu->item(strtolower(trans('navbar.themes_apps')))->add(trans('navbar.develop'), $prefix.'/develop');*/

        });


       /* \Menu::make('RightMenu', function($menu) {

            $menu->add(trans('navbar.dashboard'), 'item-1-url');
            $menu->add(trans('navbar.news'), 'item-2-url');
            $menu->add(trans('navbar.users'), 'item-3-url');

        });*/



        return $next($request);
    }
}
