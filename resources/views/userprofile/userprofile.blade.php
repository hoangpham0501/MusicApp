@extends('master')
@section('title','Edit Profile')

@section('content')

<div class="container">
 @if (Auth::check())
 @if (isset($success) and $success!=null)
     <script>
     swal('Your profile has been changed successfully!','','success');
    </script>
@endif
  <center><h3 class="page-header">Edit Profile</h3></center>

  <div class="row">
    <!-- edit form column -->

      <form class="form-horizontal" action="{{ URL::to('/userprofile') }}" method="POST">
      {!! csrf_field() !!}
       <div class="small-5 small-centered columns">
        <div >

          <div >
            <input  name="firstname" value="{{$first_name}}" type="text" class="user_input" placeholder="First Name">
          </div>
          </div>
        </div>
        <div class="small-5 small-centered columns">
        <div >

          <div class="col-lg-8">
            <input  name="lastname" value="{{$last_name}}" type="text" class="user_input" placeholder="Last Name">
            </div>
          </div>
        </div>
          <div class="small-5 small-centered columns">
        <div class="form-group">
          <div >
            <input name="address" value="{{$address}}" type="text" class="user_input" placeholder="Address">
            </div>
          </div>
        </div>

        <div class="small-5 small-centered columns">
          <div >

          <div >
            <input  name="confirmpass" value="" type="password" class="user_input" placeholder="Confirm password">
            </div>
            @if(isset($msg) and $msg!=null)
            <p class="error" style="text-align:center;">{{$msg}}</p>
            @endif
          </div>
        </div>
        <div class="input-group-button">
            <input type="submit" class="button  expand user_button" value=" Save ">
              <span></span>
              <input type="reset" class="button expand user_button" value="Reset">
             <a href={{ URL::to('/') }} class="button expand user_button" >Cancel</a>
          </div>
      </form>
    </div>
  </div>
  @else
  <p style="text-align:center;">Login to continue</p>
  <div class="input-group-button">
    <a href="auth/login" type="submit" class="button expand" >Login</a>
  </div>
  @endif
</div>

@endsection
