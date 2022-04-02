<?php

namespace App\Controllers;

use App\Libs\Controller;
use App\Model\Page;

class WebsiteController extends Controller {

    private $engines = [
                'hcms' => \App\Libs\ThemeEngine::class,
                'blade' => \App\Libs\BladeThemeEngine::class,
                //'twig' => \App\Libs\TwigThemeEngine::class,
                ];

    public $theme;


    public function before() {
        $this->theme = new \App\Libs\Theme($this->request->settings['theme']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page) {
        
        if(\Session::has("lang")){
            \App::setLocale(\Session::get("lang"));
        }
        if($this->request->has("lang")){
            \App::setLocale($this->request->input("lang"));
        }

        $theme_engine = new $this->engines[$this->theme->getConfig('theme_engine','hcms')]($this->request);
        $theme_engine->setTheme($this->theme);

        $theme_engine->boot();

        $theme_engine->runScript('before');
        

            if($this->request->settings['website_down']==1 && (\Auth::user()==null || !\Auth::user()->isAdmin())){
                return $theme_engine->renderWebsiteDown();
            }


            $requested_page = ($page=="" || $page==NULL)? Page::find($this->request->settings['home_page']) : Page::findBySlug($page);
  

            \App\Model\Visits::newVisitor($this->request);
          

            if($requested_page!=NULL){
                if(isset($requested_page->url) && $requested_page->url!="" && $theme_engine->templateExists($requested_page->url)){
                    $template = "page_templates.".$requested_page->url;
                }else{
                    $template = 'page';
                }
            }else{
                 return $theme_engine->render404();
            }


            $theme_engine->pageTemplate($template);


            $theme_engine->runScript('before_render');


        return $theme_engine->render([
                                    '_REQUESTED_PAGE' => $requested_page,
                                    ]);
    }

    public function registration() {

        if($this->request->isMethod('POST')) {

            $user = new \App\Model\User();

            $user->name = $this->request->input('name');
            $user->username = $this->request->input('username');
            $user->password = $this->request->input('password');
            $user->email = $this->request->input('email');
            $user->active = 0;

            if($user->save()) {
                return $this->redirectToSelf()->withMessage(['success' => trans('message.successfully_created_user')]);
            }

        }

        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }


    public function authenticate() {

        if($this->request->isMethod('POST')) {

            $mode = $this->request->has('email')? 'email' : 'username';

            if (\Auth::attempt([$mode => $this->request->input($mode), 'password' => $this->request->input('password')])) {

                $redirect = $this->request->has('redirect_success')? $this->redirect($this->request->input('redirect_success')) : $this->redirectToSelf();

                return $redirect->withMessage(['success' => trans('message.successfully_logged_in')]);
            }

        }

        return $this->redirectToSelf()->withMessage(['danger' => trans('message.something_went_wrong')]);
    }

    public function language(){

        if($this->request->has("lang")){
            \Session::put('lang',$this->request->input("lang"));
        }
        
        return $this->redirectToSelf();
    }

    public function search() {
    
        if($this->request->isMethod('POST')) {	
            
			if($this->request->input('search')=="" || $this->request->input('search')==null){
				return $this->redirectToSelf();
			}

            
			$search_engine = new \App\Libs\SearchEngine();

			$search_engine->registerModel(\App\Model\Blogpost::class);
            $search_engine->registerModel(\App\Model\Page::class);
            $search_engine->registerModel(\App\Model\User::class);    
            
            foreach($this->theme->getConfig('search_models',[]) as $model){
                $search_engine->registerModel($model);  
            }
            
			$search_engine->executeSearch($this->request->input('search'));
         
			return $this->redirect(\App\Model\Page::getByFunction('search.php')->slug)->withSearchResult(
																							       $search_engine
																							     );
		}

        return $this->redirectToSelf();
           
    }

    public function logout() {

        \Auth::logout();

        return $this->redirectToSelf();
    }



}
