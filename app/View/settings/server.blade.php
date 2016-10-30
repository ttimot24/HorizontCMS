@extends('layout')

@section('content')
<div class='container main-container'>
<h1>Server Information</h1>
<br><br>

<table class='table table-bordered'>
<thead>
	<th>Name</th>
	<th>Value</th>
</thead>
<tbody> 

	@foreach(array_keys($_SERVER) as $key)
		<tr>
			<td><b>{{$key}} : </b></td><td>{{ $_SERVER[$key] }}</td>
		</tr>
	@endforeach

</tbody>
</table>
</div>
@endsection