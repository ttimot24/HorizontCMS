@extends('layout')

@section('content')
<div class='container'>
<section class="row">
<h1>Server Information</h1>
<br><br>

<table class='table table-bordered'>
<thead>
	<th class="col-md-4">Name</th>
	<th class="col-md-8">Value</th>
</thead>
<tbody> 

	@foreach(array_keys($_SERVER) as $key)
		<tr>
			<td class="col-md-4"><b>{{$key}} : </b></td><td class="col-md-8">{{ $_SERVER[$key] }}</td>
		</tr>
	@endforeach

</tbody>
</table>
</section>
</div>
@endsection