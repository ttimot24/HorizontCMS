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



            $menu->add(trans('navbar.pages'), 'item-2-url');
            $menu->add(trans('navbar.media'), 'item-2-url');
            $menu->add(trans('navbar.themes_apps'), 'item-2-url');

        });


       /* \Menu::make('RightMenu', function($menu) {

            $menu->add(trans('navbar.dashboard'), 'item-1-url');
            $menu->add(trans('navbar.news'), 'item-2-url');
            $menu->add(trans('navbar.users'), 'item-3-url');

        });*/



        return $next($request);
    }
}
