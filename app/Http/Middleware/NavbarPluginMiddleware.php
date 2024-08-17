<?php

namespace App\Http\Middleware;

use Closure;

class NavbarPluginMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {

    if (app()->plugins != null && !app()->plugins->isEmpty()) {

      $main_menu = \Menu::get('MainMenu');
      $right_menu = \Menu::get('RightMenu');


      foreach (app()->plugins as $plugin) {

        try {

          if (!auth()->user()->hasPermission(str_slug($plugin->root_dir, '_'))) {
            continue;
          }

          $plugin_nav = $plugin->getRegister('navigation', []);

          foreach ($plugin_nav as $key => $item) {

            $item['url'] = isset($item['url']) ? $item['url'] :

              rescue(function () use ($plugin) {
                return route('plugin.' . str_slug($plugin->root_dir) . ".start.index");
              }, function () use ($plugin) {
                return plugin_link(namespace_to_slug($plugin->root_dir));
              });

            if (!isset($item['menu']) || $item['menu'] == 'main') {
              if (isset($item['submenu_of'])) {
                $main_menu->find($item['submenu_of'])->add($item['label'], $item['url'])->id($key);
              } else {
                $main_menu->add($item['label'], $item['url'])->id($key);
              }
            } else if (isset($item['menu']) && $item['menu'] == 'right') {
              if (isset($item['submenu_of'])) {
                $right_menu->find($item['submenu_of'])->add($item['label'], $item['url'])->id($key);
              } else {
                $right_menu->add($item['label'], $item['url'])->id($key);
              }
            }
          }
        } catch (\Error $e) {
          // throw $e;
        }
      }
    }

    return $next($request);
  }
}
