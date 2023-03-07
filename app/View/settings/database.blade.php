@extends('layout')

@section('content')
    <div class='container'>
        <div class="card mb-3">
            <div class="card-header fw-bold">
                <div class="row">
                    <div class='col-md-8'>
                        <h2>{{ trans('settings.database') }}</h2>
                    </div>

                    <div class='col-md-4 text-end'><br>
                        <a class='btn btn-primary' disabled>Backup database</a>
                    </div>
                </div>
            </div>

            <div class="card-body">
            <table class='table table-bordered table-hover'>
                <thead>
                    <th class="col-md-8">Table</th>
                    <th class="col-md-4">Action</th>
                </thead>
                <tbody>

                    @foreach ($tables as $table)
                        @foreach ($table as $key => $value)
                            <tr>
                                <td class="col-md-8"><b>{{ $value }}</b></td>
                                <td class="col-md-4"> </td>
                            </tr>
                        @endforeach
                    @endforeach


                </tbody>
            </table>
            </div>
    </div>
@endsection
