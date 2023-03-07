@extends('layout')

@section('content')
    <div class='container'>
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <h2>{{ trans('Server Information') }}</h2>
            </div>

        <div class="card-body">

            <table class='table table-bordered'>
                <thead>
                    <tr class="d-flex">
                        <th class="col-md-4">Name</th>
                        <th class="col-md-8">Value</th>
                    </tr>

                </thead>
                <tbody>

                    @foreach ($server as $key => $value)
                        <tr class="d-flex">
                            <td class="col-md-4"><b>{{ $key }} : </b></td>
                            <td class="col-md-8" style="word-break: break-all;">{{ $value }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection
