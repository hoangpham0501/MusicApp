<!-- resources/views/auth/register.blade.php -->

@extends('master')

@section('title', 'Register')


@section('content')


<form  method="POST" action="{{ URL::to('auth/register') }}">
{!! csrf_field() !!}
    <center><h3 class="page-header">Register</h3></center>
    <div class="row">
        <div class="small-5 columns small-centered">
            <input type="text" name="name" value="{{ old('name') }}" class="reg_input" placeholder="Name">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    @if(strpos($error, 'name')>0)
                        <p class="error">{{$error}}</p>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    <div class="row">
        <div class="small-5 small-centered columns">
            <input type="email" name="email" value="{{ old('email') }}" class="reg_input" placeholder="Email">
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
            <input type="password" name="password" class="reg_input" placeholder="Password">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    @if(strpos($error, 'required') > 0 || strpos($error, 'characters') > 0 || strpos($error, 'least') > 0)
                       <p class="error">{{$error}}</p>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    <div class="row">
        <div class="small-5 small-centered columns">
            <input type="password" name="password_confirmation" class="reg_input" placeholder="Confirm Password">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    @if(strpos($error, 'confirmation')>0)
                        <p class="error">{{$error}}</p>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    <div class="input-group-button">
        <input type="submit" class="button expand log_reg_button" value="Register">
    </div>
</form>

@endsection
