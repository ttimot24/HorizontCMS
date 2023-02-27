@extends('layout')

@section('content')
<div class='container main-container'>


<h2>Online Store</h2>
<hr>
<br>

<div class="row">

    @if(!$repo_status || $repo_status)

      <div class="alert alert-warning" role="alert">
        <div><b>Warning</b> Theme store unreachable!</div>
      </div>

    @endif


	</div>

</div>
@endsection
