@extends('layout')

@section('content')
<div class='container'>
<section class="row">
<div class="col-md-8">
<h1>{{trans('settings.database')}}</h1>
</div>
<div class='col-md-4'>
<br>
	<a class='btn btn-primary pull-right' disabled>Backup database</a>
</div>
<br><br><br><br>


<table class='table table-bordered table-hover'>
<thead>
	<th class="col-md-8">Table</th>
	<th class="col-md-4">Action</th>
</thead>
<tbody> 

	@foreach($tables as $table)
    	@foreach($table as $key => $value)   
        <tr>
			<td class="col-md-8"><b>{{$value}}</b></td><td class="col-md-4"> </td>
		</tr>
        @endforeach
	@endforeach


</tbody>
</table>
</section>
</div>
@endsection