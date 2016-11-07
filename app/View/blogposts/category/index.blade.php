@extends('layout')

@section('content')
<div class='container main-container'>
<div class='row'>
<div class='col-md-12'>

<h2 class='pull-left'>{{ trans('category.category') }}:</h2>



<form action="{{ admin_link('blogpost_category-create') }}" class='form-inline' role='form' method='POST'>
<div style='text-align:right;'>
</br>
<label for='cat'>{{ trans('category.add_category') }}:</label> 
	<div class='form-group'>
		<div class='col-sm-6'>  
			<input type='text' class='form-control' id='cat' name='name' placeholder='Enter new category' required>
	</div></div> 
<div class='form-group'>
 <button type='submit' class='btn btn-primary'>{{ trans('actions.add') }}</button> 
 </div>
 </div></form>
 
<table class='table table-hover' style='margin-top:5%;'>
    <thead>
      <tr>
      	<th>{{ trans('category.th_id') }}</th>
      	<th>{{ trans('category.th_image') }}</th>
      	<th>{{ trans('category.th_category') }}</th>
        <th>{{ trans('category.th_posts') }}</th>
        <th><center>{{trans('actions.action')}}</center></th>
      </tr>
    </thead><tbody>



	@foreach($all_category as $each)
	<tr>
			<td>{{ $each->id }}</td>
			<td><img src='{{ $each->getThumb() }}'  class='img img-rounded' style='object-fit:cover;' width="70" height="50" /> </td>
	        <td>{{ $each->name }}</td>     

	<td><span class='badge'>{{ $each->blogposts->count() }}</span></td>

			<td><center>

	        <div class='btn-group' role='group'>
         		<a href="{{ admin_link('blogpost_category-edit',$each->id) }}" type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>{{trans('actions.edit')}}</a>
           		<a href="{{ admin_link('blogpost_category-delete',$each->id) }}" type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
       		</div>";

	      </center></td></tr>
	@endforeach




	</tbody>
  </table>

</div>
</div>
</div>
@endsection