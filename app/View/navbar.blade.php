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
                 <a class='navbar-brand' href="{{url(admin_link(null))}}">
                    <img src="{{ url(config('horizontcms.admin_logo')) }}" style='max-height:170%;margin-top:-7px;float:left;'> <!--HorizontCMS <!-- SatelliteCMS -->
                  </a>
                  <div class='visible-xs navbar-brand' style='color:white;text-align:center;'>{{ config('app.name') }}</div>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                  @include(config('laravel-menu.views.bootstrap-items'), array('items' => $MainMenu->roots()))
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right" style='padding-right:25px;'>


                  @include(config('laravel-menu.views.bootstrap-items'), array('items' => $RightMenu->roots()))
                    

                    <form id="logout-form" action="{{ url(admin_link('login-logout')) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </ul>
            </div>
        </div>
    </nav>