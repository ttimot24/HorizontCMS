@extends('layout')

@section('content')
<div class="container main-container">

<h1>{{trans('settings.settings')}}</h1>
<br>
<br>

<div class="container col-md-12">

@foreach($panels as $each)

<a href='<?= $each['link'] ?>'>
	<div class='well col-md-3'>

			<center>
				<i class="{{ $each['icon'] }}" style='font-size:60px;'></i>
				<h4>{{ $each['name'] }}</h4>
			</center>

	</div>	
</a>

@endforeach

</div>

</div>
<br><br>
@endsection