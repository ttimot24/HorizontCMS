@extends('layout')

@section('content')
    <div class='container main-container'>

        <h2 class="mb-5">Social media</h2>

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
@endsection
