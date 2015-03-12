@extends('app')

@section('content')


<form action="<?= url('register') ?>" method="post" data-abide>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row full-width">
        <div class="medium-2 columns">
            <label class="inline" for="username">Username:</label>
        </div>
        <div class="medium-6 columns">
            <input type="text" name="username" value="{{ old('username') }}" id="username" class="focus-me" required />
            <span class="error">This field is required.</span>
        </div>
        <div class="medium-4 columns">
        </div>
    </div>

    <div class="row full-width">
        <div class="medium-2 columns">
            <label class="inline" for="email">Email:</label>
        </div>
        <div class="medium-6 columns">
            <input type="text" name="email" value="{{ old('email') }}" id="email" />
        </div>
        <div class="medium-4 columns">
        </div>
    </div>

    <div class="row full-width">
        <div class="medium-2 columns">
            <label class="inline" for="password">Password:</label>
        </div>
        <div class="medium-3 columns">
            <input type="password" name="password" id="password" placeholder="Enter passord" required />
            <span class="error">This field is required.</span>
        </div>
        <div class="medium-3 columns">
            <input type="password" name="password_confirmation" placeholder="Repeat password" data-equalto="password" />
            <span class="error">This field must match the password.</span>
        </div>
        <div class="medium-4 columns">
        </div>
    </div>

    <div class="row full-width">
        <div class="medium-2 columns">
            &nbsp;
        </div>
        <div class="medium-5 columns">
            <input type="submit" class="button" value="Register" />
        </div>
        <div class="medium-5 columns"></div>
    </div>

</form>


@endsection
