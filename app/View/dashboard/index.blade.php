@extends('layout')

@section('content')
<div class='container main-container' id='dashboard' style='margin-bottom: -35px;'> 

    <div class='row'>
      <div class='col-xs-12 col-sm-12 col-md-4'>

     <center></br></br><h3>{{ $domain }}</h3>
      <p class='text-muted'>{{ trans('dashboard.server_ip')." ".$server_ip }}</p>
     <p class='text-muted'>{{ trans('dashboard.client_ip')." ".$client_ip }}</p></center>

    <hr>
    <div class='col-md-10 col-md-offset-1'><center>
    <h4>{{ trans('dashboard.disk_usage') }}</h4>
    <div class="progress">

      <div class="progress-bar progress-bar-primary" style="width: {{ 100-$disk_space }}%">
      {{ number_format(100-$disk_space,2) }}%
        <span class="sr-only">35% Complete (success)</span>
      </div>

    </div></center>
    </div>


     </div>


      <div class='col-xs-12 col-sm-12 col-md-4'><center>
          <img src='{{ url($admin_logo) }}' class='img img-responsive img-rounded' style='margin-top:40px;margin-bottom:-30px;max-height:250px;'/>
          
          </center>
        </div>

     <div class='clearfix visible-xs-block'></div>

      <div class='col-xs-12 col-sm-12 col-md-4'>   



        </br></br></br><center

        @if(\Auth::user()->hasPermission('search'))
        <form class='form-inline' action="{{admin_link('search-index')}}" method='POST'>
            {{ csrf_field() }}
          <div class='form-group'>
            <div class='input-group'>
            <input type='text' class='form-control' name='search' id='exampleInputAmount' style='min-width:250px;'  placeholder="{{ trans('dashboard.search_bar') }}" required>
               <div class='input-group-addon'>
                <button type='submit' class='btn btn-link btn-sm' style='padding:0px;'>
                <span class='glyphicon glyphicon-search' aria-hidden='true' ></span>
                </button>
                </div>
       
            </div>
          </div>
        </form>
        @endif

        </center>

     
       @if($upgrade!=null && $upgrade->newVersionAvailable())
        <div class="alert alert-warning alert-dismissible col-md-10 col-md-offset-1" role="alert" style='margin-top:5%;'>
    		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		  <strong>{{ trans('dashboard.update_available')." v".$upgrade->getLatestVersion()}}</strong><br>{{ trans('dashboard.update_message') }}<br><br>
    		  <a href='{{ admin_link("settings-update-center") }}' class='btn btn-primary btn-block'>{{ trans('dashboard.update_now') }}</a>
    		</div>
      @endif

         </div>
    </div>

    <center><h1>{{ trans('dashboard.welcome_message') }}</h1></center>

	</br>
    <div class='container col-md-12'>
      <div class='row'>
        
        <div class='col-sm-4'>
          <div class='panel panel-primary'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b>{{ trans('dashboard.posted_news_count') }}</b><div class='pull-right'><i class='fa fa-newspaper-o'></i></div></h3>
            </div>
            <div class='panel-body'><center><font size='4'>
            {{ $blogposts }}
           </font></center></div>
          </div>
        </div>


        <div class='col-sm-4'>
          <div class='panel panel-primary'>
            <div class='panel-heading'>
              <h3 class='panel-title'><b>{{ trans('dashboard.registered_users_count') }}</b><div class='pull-right'><i class='fa fa-users'></i></div></h3>
            </div>
              <div class='panel-body'><center><font size='4'>
               {{ $users }}
           </font></center></div>
          </div>
        </div>

        <div class='col-sm-4'>
          <div class='panel panel-primary'>
            <div class='panel-heading' >
              <h3 class='panel-title'><b>{{ trans('dashboard.visits_count') }}</b><div class='pull-right'><i class='fa fa-binoculars'></i></div></h3>
            </div>
            <div class='panel-body'><center><font size='4'>
             {{ $visits }}
           </font></center></div>
          </div>
        </div>

       
      </div>


    </div>



</div>
@endsection
