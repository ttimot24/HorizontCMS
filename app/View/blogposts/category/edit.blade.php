@extends('layout')

@section('content')
    <div class='container main-container'>

            <div class="card mb-3">
            <div class="card-header fw-bold">
        <h2>{{ trans('category.edit_category') }}</h2>

</div>


        <div class='card-body'>

            <form action="{{ route('blogpostcategory.update', ['blogpostcategory' => $category]) }}"
                class='form-inline float-right mt-4' role='form' method='POST'>

                @csrf
                @method('PUT')

                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">Rename:</label>
                    </div>
                    <div class="col-auto">
                        <input type='text' class='form-control' id='cat' name='name'
                            value="{{ $category->name }}" required autofocus>
                    </div>
                    <div class="col-auto">
                        <span class="form-text">
                            <button type='submit' class='btn btn-primary'>{{ trans('actions.save') }}</button>
                        </span>
                    </div>
                </div>

            </form>

            <div class="mt-5">
                <a href="{{ route('blogpostcategory.index') }}" class="btn btn-info">{{ trans('actions.back') }}</a>
            </div>

            </div>

        </div>
    @endsection
