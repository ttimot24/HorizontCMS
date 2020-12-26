@extends('layout')

@section('content')
<div style='width:100%'>
  <div class='jumbotron'>
    <div class='container'>
    <h1>{{ config('app.name') }} <small style="font-size:22px;">by Timot Tarjani</small></h1>      
    <p>The CMS that fit exactly to your needs.</p></br> 
    <?php 
      //require(VIEW_DIR."default/messages.php");
    ?>
    <p>

 @if($enable_continue)
   
   <a class='btn btn-primary btn-lg' href='admin/install/step1' >

      &nbsp&nbsp&nbspInstall {{ config('app.name') }}&nbsp&nbsp&nbsp<span class='glyphicon glyphicon-menu-right' aria-hidden='true'></span>

    </a>


 @else{
   <a class='btn btn-success btn-lg' href='' >

      &nbsp&nbsp<i class='fa fa-refresh' aria-hidden='true'></i>&nbspRefresh&nbsp&nbsp&nbsp

    </a>
  @endif

    </p>     
  </div>
  </div>

  <div class='container'>

      <div class="row">

          <div class='col-sm-6 col-md-4 text-center'>
              <i class="fa fa-cube" aria-hidden="true" style='font-size:3em;'></i>
              <div class='caption'>
                <h3>Modern tools</h3>
                <p>{{ config('app.name') }} was created with the most modern webtools. Laravel {{\App::VERSION()}} on it's backend, Bootstrap 3.4.1 and VueJs 2.6.10 makes the perfect user experience on frontend.</p>
              </div>
          </div>

          <div class='col-sm-6 col-md-4 text-center'>
              <i class="fa fa-coffee" aria-hidden="true" style='font-size:3em;'></i>
              <div class='caption'>
                <h3>Content handling</h3>
              <p>Contact your users, create new pages, handle your files or just run a blog. {{ config('app.name') }} will take care of the rest behind the scenes.</p>
              </div>
          </div>

          <div class='col-sm-6 col-md-4 text-center'>
              <i class="fa fa-cloud-download" aria-hidden="true" style='font-size:3em;'></i>
              <div class='caption'>
                <h3>Central repository</h3>
                <p>Free plugins, themes  and language packs are downloadable with only one click. You don't have to be a developer to extend the system. System upgrades are also only one click away.</p>
              </div>
          </div>
      </div>
  </div>

</div>
@endsection