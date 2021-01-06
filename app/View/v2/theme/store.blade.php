@extends('layout')

@section('content')
<div class='container main-container'>


<h2>Online Store</h2>
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
