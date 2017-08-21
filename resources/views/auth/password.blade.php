<!-- resources/views/auth/password.blade.php -->
<!-- resources/views/auth/login.blade.php -->

@extends('master')

@section('title', 'Forgot password')

@section('content')

@if ($alert = Session::get('status'))
   <script> 
        swal('Sent!','Check your email to reset password.', 'success');
    </script>
@endif
<center class="auth">
<h3>Password Reset</h3>
<p>To reset your password, enter the email address you use to sign in.</p>
<form method="POST" action="{{ URL::to('/password/email') }}">
    {!! csrf_field() !!}

    <div class="row">
        <div class="small-5 colums">
            <input type="email" name="email" value="{{ old('email') }}" class="forgotpass_input" placeholder="Your Email">
            @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach

            @endif
        </div>

        <div class="small-5 colums">
            <button type="submit" class="button forgotpass_button">
                Submit
            </button>
        </div>
    </div>

</form>
</center>
@endsection
