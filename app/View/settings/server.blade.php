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

	@foreach($server as $key => $value)
		<tr> <td><b>{{$key}} : </b></td><td style="word-break: break-all;">{{ $value }}</td> </tr>
	@endforeach

</tbody>
</table>
</section>
</div>
@endsection