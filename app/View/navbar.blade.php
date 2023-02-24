<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top p-0">
<div class="container-fluid">
            <!-- Branding Image -->
            <a class='navbar-brand m-0 p-0 ps-2 pe-3' href="{{route('dashboard.index')}}">
                <img src="{{ url(config('horizontcms.admin_logo')) }}" class="m-0 p-0 h-100"> <!--HorizontCMS <!-- SatelliteCMS -->
            </a>
            <div class='d-block d-sm-none navbar-brand'>{{ config('app.name') }}</div>
    
            <!-- Collapsed Hamburger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  @include(config('laravel-menu.views.bootstrap-items'), ['items' => $MainMenu->roots()])
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav mr-3 justify-content-end">


                  @include(config('laravel-menu.views.bootstrap-items-right'), ['items' => $RightMenu->roots()])
                    

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </ul>
            </div>
        </div>
    </nav>