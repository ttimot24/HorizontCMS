@extends('layout')

@section('content')
<div class='container'>
<section class="row">
<h1>Server Information</h1>
<br><br>

<table class='table table-bordered'>
<thead>
	<tr class="d-flex">
		<th class="col-md-4">Name</th>
	<th class="col-md-8">Value</th>
	</tr>
	
</thead>
<tbody> 

	@foreach($server as $key => $value)
		<tr class="d-flex"> <td class="col-md-4"><b>{{$key}} : </b></td><td class="col-md-8" style="word-break: break-all;">{{ $value }}</td> </tr>
	@endforeach

</tbody>
</table>
</section>
</div>
@endsection