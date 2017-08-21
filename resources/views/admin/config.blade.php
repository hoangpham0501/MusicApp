@extends('master')
@section('title','Admin Config')
@section('content')
@if (Auth::check() and (Auth::user()->role=="admin"))
  <center><h1 class="page-header">Music Scheduler</h1></center>
<form class="form-horizontal" action="{{ URL::to('admin/config') }}" method="POST">

	{!! csrf_field() !!}
    <div class="container config">
        
        <div class="row">
            <table>
                <thead>
                    <tr>
                        <th><center>Start Time</center></th>
                        <th><center>Duration</center></th>
                        <th><center>Option</center></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="width: 33%"><input type="time" name="start_time" value="{{$start_time}}" class="timePicker"></td>
                        <td style="width: 33%"><input type="number" min='0' max='999' id="duration" name="duration" value="{{$duration}}"></td>
                        <td style="width: 34%">
                            <div class="form-group">
                                <select class="form-control" id="sel1" name="option" value="{{$option}}">
                                @if ($option == "Minutes")
	                                <option value ="Minutes" selected>Minutes</option>
	                                <option value ="Songs">Songs</option>
                                @else
	                                <option value ="Minutes">Minutes</option>
	                                <option value ="Songs" selected>Songs</option>
                                @endif
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>    
        
            <div class="input-group-button">
                <center>
                    <input type="submit" class="button  user_button" value="Save">
                    <a href={{ URL::to('admin/config') }} class="button  user_button" >Cancel</a>
                </center>
            </div>
        </div> 
    </div>   

</form>

@else
    <h1 style="text-align:center; color: red; font-size: 70px; margin-top: 100px;">Oops! Login to continue</h1>
@endif

@endsection
