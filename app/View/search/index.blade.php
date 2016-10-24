@extends('layout')

@section('content')
<div class='container main-container'>

<h2 style='width:50%;' class='pull-left'>{{trans(search.found_matches,['quantity' => ($blogposts->count()+$users->count()+$pages->count()+$files->count()),
                                                                       'search_word' => $search_for ])}}</h2> 

<form class='form-inline' action='admin/search' method='POST'>
<br>
          <div class='form-group pull-right'>
            <div class='input-group'>
            <input type='text' class='form-control' name='search' id='exampleInputAmount' style='width:250px;' placeholder="{{ trans('dashboard.search_bar') }}" required>
               <div class='input-group-addon'>
                <button type='submit' class='btn btn-link btn-sm'  style='margin:0px;padding:0px;'>
               <span class='glyphicon glyphicon-search' aria-hidden='true' size=1></span></div>
               </button>
            </div>
          </div>
         <!-- <button type='submit' class='btn btn-primary'>Search</button>-->
        </form>

</br></br></br>


<h3 style='clear:both;'>{{trans('blogpost.blogposts')}} ({{$blogposts->count()}})</h3>
<div class='container'>
<?php 
foreach ($blogposts as $each) {
	echo "<a href='admin/blogpost/show/".$each->id."'>" .$each->title ."</a></br>";
}

?>
</div>


<h3>{{trans('user.users')}} ({{$users->count()}})</h3>
<div class='container'>

<?php 
foreach ($users as $each) {
	echo "<a href='admin/user/view/".$each->id."'>" .$each->username ."</a></br>";
}

?>
</div>


<h3>{{trans('page.pages')}} ({{$pages->count()}})</h3>
<div class='container'>
<?php 
  foreach ($pages as $each) {
  	echo "<a href='admin/page/view/".$each->id."'>" .$each->name ."</a></br>";
  }
?>
</div>

<h3>{{trans('file.files')}} ({{$files->count()}})</h3>
<div class='container'>
<?php 
    foreach ($files as $each) {
      echo "<a href=''>" .$each ."</a></br>";
    }
?>
</div>


</br></br></br></br></br>
@endsection;