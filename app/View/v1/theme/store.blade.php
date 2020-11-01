@extends('layout')

@section('content')
<div class='container main-container'>


<h1>Online Store</h1>
<hr>
<br>

<div class="row">

<?php 
if(!$repo_status || $repo_status){

  echo (new BootstrapMessage())->warning("Theme store unreachable!"); 
}

?>


	</div>

</div>
@endsection
