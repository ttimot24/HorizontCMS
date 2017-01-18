<nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                 <a class='navbar-brand' href="{{url(Config::get('horizontcms.backend_prefix'))}}">
                    <img src="{{ url(config('horizontcms.admin_logo')) }}" style='max-height:170%;margin-top:-7px;float:left;'> <!--HorizontCMS <!-- SatelliteCMS -->
                  </a>
                  <div class='visible-xs navbar-brand' style='color:white;text-align:center;'>HorizontCMS</div>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                  @include(config('laravel-menu.views.bootstrap-items'), array('items' => $MainMenu->roots()))
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" style='padding-right:25px;'>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img style='height:30px;margin-top:-10px;margin-bottom:-10px;object-fit:cover;border-radius:1.5px;' src='{{Auth::user()->getThumb()}}' />  {{ Auth::user()->username }} <span class="caret"></span>
                        </a>

                         <ul class="dropdown-menu" role="menu" style='width:215px;'>
                           <li class='nav-item' style="text-align:center;"><img style="border-radius:1.5px;width:90%;height:135px;margin:10px 3% 10px 3%;object-fit:cover;" class="img-rounded" src='{{Auth::user()->getThumb()}}' /><br>
                            <p style='color:white;'>{{\Auth::user()->username}} ({{strtolower(\Auth::user()->role->name)}})</p>
                           </li>

                           <li role="separator" class="divider"></li>
                           <li class='nav-item'><a href="{{admin_link('user-view',\Auth::user()->id)}}">View profile</a></li>
                           <li class='nav-item'><a href="{{admin_link('user-edit',\Auth::user()->id)}}">Profile settings</a></li>
                         </ul>
                    </li>

                    @include(config('laravel-menu.views.bootstrap-items'), array('items' => $RightMenu->roots()))
                    
                       <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url(Config::get('horizontcms.backend_prefix').'/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>


                                </li>
                            </ul>
                        </li>-->

                    <form id="logout-form" action="{{ url(Config::get('horizontcms.backend_prefix').'/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </ul>
            </div>
        </div>
    </nav>