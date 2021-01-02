<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top p-1">
            <!-- Branding Image -->
            <a class='navbar-brand m-0 p-0 pr-3 pl-2' href="{{url(admin_link(null))}}">
                <img src="{{ url(config('horizontcms.admin_logo')) }}" class="m-0 p-0 h-100"> <!--HorizontCMS <!-- SatelliteCMS -->
            </a>
            <div class='d-block d-sm-none navbar-brand'>{{ config('app.name') }}</div>
    
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggler collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                  @include(config('laravel-menu.views.bootstrap-items'), array('items' => $MainMenu->roots()))
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto mr-3">


                  @include(config('laravel-menu.views.bootstrap-items'), array('items' => $RightMenu->roots()))
                    

                    <form id="logout-form" action="{{ url(admin_link('login-logout')) }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </ul>
            </div>
    </nav>