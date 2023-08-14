@extends('layout')

@section('content')
    <div class='container main-container'>

        <div class="card mb-3">
            @include('breadcrumb', [
                'links' => [['name' => trans('settings.settings'), 'url' => route('settings.index')]],
                'page_title' => trans('Social media'),
            ])
        <div class="card-body">
        <form action='' role='form' method='POST'>
            @csrf

            <table class='table-bordered' id='settings' style='width:100%;text-align:center;'>

                <tbody style='text-align:center;font-weight:bolder;'>
                    
                    @foreach ($all_socialmedia as $each)
                        <tr>
							<td>
                    			<i class='fa fa-{{$each->getName()}}"' aria-hidden='true' style='font-size:26px;'></i> 
                            {{ ucfirst($each->getName()) }}
                            </td>
							<td>
                    			<input type='text' class='form-control' name='{{$each->getName()}}' value='{{htmlspecialchars($each->value)}}'>
                    		</td>
						</tr>
                    @endforeach


                    <tr>
                        <td></td>
                        <td><button type='submit' class='btn btn-primary'>
                                <span class='fa fa-floppy-o' aria-hidden='true'></span> {{ trans('settings.adminarea_save_settings') }}</button> </td>
                    </tr>

                </tbody>
            </table>
        </form>
        </div>
    </div>
@endsection
