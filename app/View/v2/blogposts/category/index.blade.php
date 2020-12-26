@extends('layout')

@section('content')
<div class='container'>
<div class='row'>

<div class="col-md-12">
<h2 class='float-left mt-5'>{{ trans('category.category') }}</h2>

<form action="{{ admin_link('blogpost_category-create') }}" class='form-inline float-right  mt-5' role='form' method='POST'>

	{{ csrf_field() }}

	<div class="d-flex">
		<label for='cat'>{{ trans('category.add_category') }}:</label> 
		<div class='form-group'>
			<div class='col-sm-6'>  
				<input type='text' class='form-control' id='cat' name='name' placeholder='Enter new category' required>
			</div>
		</div> 
		<div class='form-group'>
			<button type='submit' class='btn btn-primary'>{{ trans('actions.add') }}</button> 
		</div>
	</div>
</form>
</div>
  
<div class='col-md-12'>

	

	
 
<table class='table table-hover' style='margin-top:5%;'>
    <thead>
      <tr class="d-flex bg-dark text-white">
      	<th class="col-1">{{ trans('category.th_id') }}</th>
      	<!--<th>{{ trans('category.th_image') }}</th>-->
      	<th class="col">{{ trans('category.th_category') }}</th>
        <th class="col">{{ trans('category.th_posts') }}</th>
        <th class="col-5 text-center">{{trans('actions.th_action')}}</th>
      </tr>
	</thead>
	<tbody>

		@foreach($all_category as $each)
		<tr class="d-flex">
				<td class="col-1">{{ $each->id }}</td>
				<!--<td><img src='{{ $each->getThumb() }}'  class='img img-rounded' style='object-fit:cover;' width="70" height="50" /> </td>
				-->
				<td class='col'><a href="{{ admin_link('blogpost_category-view',$each->id) }}">{{ $each->name }}</a></td>     

				<td class="col">
					<span class='badge'>{{ $each->blogposts->count() }}</span>
				</td>

				<td class="col-5  text-center">
	
				<div class='btn-group col-3' role='group'>
					<a href="{{ admin_link('blogpost_category-edit',$each->id) }}" type='button' class='btn btn-warning btn-sm' style='min-width:70px;'>{{trans('actions.edit')}}</a>
					<a href="{{ admin_link('blogpost_category-delete',$each->id) }}" type='button' class='btn btn-danger btn-sm'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
				</div>

			</td>
		</tr>
		@endforeach

	</tbody>
  </table>

</div>
</div>
</div>
@endsection