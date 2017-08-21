
@extends('master')

@section('title', 'Change Password')

@section('content')

<form method="POST" action="{{ URL::to('changepassword') }}">
{!! csrf_field() !!}
@if (isset($msg) and $msg!=null)
     <script>
     swal('Your password has been changed successfully!','','success');
    </script>
@endif
  @if((isset($wrongcurrent) and $wrongcurrent!=null) or (isset($wrongnew) and $wrongnew!=null))
  <script >
  swal('Oops', 'Some field are incorrect.','error');
  </script>
@endif

<center><h3 class="page-header">Change Password</h3></center>
  <div class="row">
        <div class="small-5 small-centered columns">
            <input type="password" name="current_password" class="changepass_input" placeholder="Current Password">
            @if(isset($wrongcurrent) and $wrongcurrent!=null)
            <p class="error" style="text-align:center;">{{$wrongcurrent}}</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="small-5 small-centered columns">
            <input type="password" name="new_password" class="changepass_input" placeholder="New Password">
           @if(isset($wrongnew) and $wrongnew!=null)
            <p class="error" style="text-align:center;">{{$wrongnew}}</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="small-5 small-centered columns">
            <input type="password" name="confirm_password" class="changepass_input" placeholder="Confirm Password">
            @if(isset($wrongnew) and $wrongnew!=null)
            <p class="error" style="text-align:center;">{{$wrongnew}}</p>
            @endif
        </div>
    </div>


    <div class="input-group-button">
        <input type="submit" class="button expand changepass_button" value="Save" >
        <a href={{ URL::to('/') }} class="button expand changepass_button" >Cancel</a>
    </div>
<!-- </form> -->

@endsection
