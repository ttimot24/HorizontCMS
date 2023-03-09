<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MenuMiddleware{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){


        \App::setLocale($request->settings['language']);


        \Menu::make('MainMenu', function($menu) use ($request) {

            $menu->add("<i class='fa fa-circle-o-notch'></i>".trans('navbar.dashboard'), route("dashboard.index"));

            if(\Auth::user()->hasPermission("blogpost")){
                $menu->add(trans('navbar.news'), '#')->id('news');
                $menu->find('news')->add("<i class='fa fa-newspaper-o'></i> ".trans('navbar.posted_news'), route('blogpost.index'));
                $menu->find('news')->add("<i class='fa fa-pencil'></i> ".trans('navbar.create_post'), route('blogpost.create'));
                $menu->find('news')->add("<i class='fa fa-list-ul'></i> ".trans('navbar.categories'), route('blogpostcategory.index'));
            }

            if(\Auth::user()->hasPermission("user")){
                $menu->add(trans('navbar.users'), '#')->id('users');
                $menu->find('users')->add("<i class='fa fa-users'></i> ".trans('navbar.user_list'), route('user.index'));
                $menu->find('users')->add("<i class='fa fa-user-plus'></i> ".trans('navbar.user_add'),route('user.create'));
                $menu->find('users')->add("<i class='fa fa-gavel'></i> ".trans('navbar.user_groups'), route('userrole.index'));
            }

            if(\Auth::user()->hasPermission("page")){
                $menu->add(trans('navbar.pages'), '#')->id('pages');
                $menu->find('pages')->add("<i class='fa fa-files-o'></i> ".trans('navbar.page_list'), route('page.index'));
                $menu->find('pages')->add("<i class='fa fa-pencil-square-o'></i> ".trans('navbar.page_add'), route('page.create'));
            }


            if(\Auth::user()->hasPermission("filemanager") || \Auth::user()->hasPermission("headerimages")){
                $menu->add(trans('navbar.media'), '#')->id('media');
                $menu->find('media')->add("<i class='fa fa-folder-open-o'></i> ".trans('navbar.filemanager'), route('filemanager.index'));
                $menu->find('media')->add("<i class='fa fa-picture-o'></i> ".trans('navbar.header_images'), route('headerimage.index'));
            }


            if(\Auth::user()->hasPermission("theme") || \Auth::user()->hasPermission("plugin")){
                $menu->add(trans('navbar.themes_apps'), '#')->id('themes_apps');

                if(\Auth::user()->hasPermission("theme")){
                     $menu->find('themes_apps')->add("<i class='fa fa-desktop'></i> ".trans('navbar.theme'), route('theme.index'));
                }

                if(\Auth::user()->hasPermission("plugin")){
                     $menu->find('themes_apps')->add("<i class='fa fa-cubes'></i> ".trans('navbar.plugin'), route('plugin.index'));
                }

            }

        });
  

        \Menu::make('RightMenu', function($menu) use ($request) {

            
                $menu->add("<img style='height:30px;margin-top:-10px;margin-bottom:-10px;object-fit:cover;border-radius:1.5px;' src='".Auth::user()->getThumb()."' />  ". \Auth::user()->username)->id('current_user');
                $menu->find('current_user')->add("<img style='border-radius:1.5px;width:95%;height:135px;margin:10px 2.5% 10px 2.5%;object-fit:cover;' class='img img-rounded' src='".Auth::user()->getThumb()."' /><br> <p style='color:white;font-size:14px;'>".\Auth::user()->username." (".strtolower(\Auth::user()->role->name).")</p>",[ 'url' => '#', 'style'=>'clear:both;width:215px;text-align:center;', 'class'=>'current-image' ])->id('current_image');
                $menu->find('current_image')->divide();
                $menu->find('current_user')->add(trans('navbar.profile_view'), ['url'=> route('user.show', ['user' => \Auth::user()])])->id('view_account');
                $menu->find('current_user')->add(trans('navbar.profile_settings'), ['url'=> route('user.edit',['user' => \Auth::user()])])->id('account_settings');
           

            if(\Auth::user()->hasPermission("settings")){
                $menu->add("<i class='fa fa-cogs'></i> ", route('settings.index'))->id('settings');
            }


                $menu->add("<i class='fa fa-power-off'></i> ", '#')->id('shutdown');
                $menu->find('shutdown')->add("<i class='fa fa-lock'></i> ".trans('navbar.lock_screen'), ['url'=>'#', 'onclick'=>'event.preventDefault();lockscreen.lock();'])->id('lock_screen');
                $menu->find('lock_screen')->divide();
                $menu->find('shutdown')->add("<i class='fa fa-external-link'></i> ".trans('navbar.visit_site',['site_name' => $request->settings['site_name']]), '');
                $menu->find('shutdown')->add("<i class='fa fa-sign-out'></i> ".trans('navbar.logout'), ['onclick' => 'event.preventDefault(); document.getElementById(\'logout-form\').submit();']);

        

        });


        return $next($request);
    }
}
