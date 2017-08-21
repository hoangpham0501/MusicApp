<!-- resources/views/auth/reset.blade.php -->

@extends('master')

@section('title', 'Forgot password')


@section('content')

<form class="auth resetpassword" >
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="row">
        <div class="small-5 small-centered columns">
          <input type="email" name="email" value="{{ old('email') }}" class="reset_input" placeholder="Email">
        </div>
    </div>

    <div class="row">
      <div class="small-5 small-centered columns">
        <input type="password" name="password" class="reset_input" placeholder="Password">
      </div>
    </div>

    <div class="row">
      <div class="small-5 small-centered columns">
          <input type="password" name="password_confirmation" class="reset_input" placeholder="Confirm Password">
      </div>
    </div>

    <div>
      <div class="input-group-button">
        <input type="submit" class="button expand reset_button"   value="Reset password">
      </div>
    </div>
</form>
@endsection