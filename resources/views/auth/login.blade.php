<!-- resources/views/auth/login.blade.php -->

@extends('master')

@section('title', 'Login')


@section('content')
<form method="POST" action="{{ URL::to('auth/login') }}">
{!! csrf_field() !!}
<center><h3 class="page-header">Login</h3></center>
  <div class="row">
    <div class="small-5 columns small-centered">
        <input type="email" name="email" value="{{ old('email') }}" class="log_input" placeholder="Email">
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                @if(strpos($error, 'email')>0)
                    <p class="error">{{$error}}</p>
                @endif
            @endforeach
        @endif
    </div>
</div>
<div class="row">

    <div class="small-5 small-centered columns">
        <input type="password" name="password" id="password" class="log_input" placeholder="Password">
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                @if(strpos($error, 'password') > 0 || strpos($error, 'credentials ') > 0)
                    <p class="error">{{$error}}</p>
                @endif
            @endforeach
        @endif
    </div>
</div>
<div class="row">
    <div class="small-5 small-centered columns">
        <div class="small-4 columns">
        <div>
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>
    </div>

    <div class="small-4 columns">
        <div>
            <a href="{{ URL::to('password/email') }}" class="forgot-password">Forgot password?</a>
        </div>
    </div>
    </div>

</div>
<div class="input-group-button">
    <input type="submit" class="button expand log_reg_button" value="Login">
  </div>
</form>

@endsection
