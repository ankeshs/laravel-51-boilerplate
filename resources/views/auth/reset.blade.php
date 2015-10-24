<!-- resources/views/auth/reset.blade.php -->

@extends('layout.main')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-card mdl-shadow--4dp mdl-cell mdl-cell--12-col">
          <div class="mdl-card__media mdl-color-text--grey-50">
            <h3>Sign Up</h3>
          </div>              
          <div class="mdl-color-text--grey-700 mdl-card">
              <form action="{{ action('Auth\PasswordController@postReset') }}" method="post">                
                <div class="mdl-textfield mdl-js-textfield">
                  <input class="mdl-textfield__input" type="text" name="email" id="email_input" value="{{ Input::old('email') }}" />
                  <label class="mdl-textfield__label" for="email_input">Email Address...</label>                   
                </div>
                @if($errors->has('email'))
                    <span>{{ $errors->first('email')}}</span>
                @endif
                <div class="mdl-textfield mdl-js-textfield">
                  <input class="mdl-textfield__input" type="password" name="password" id="password_input" />
                  <label class="mdl-textfield__label" for="password_input">Password...</label>                   
                </div>
                @if($errors->has('password'))
                    <span>{{ $errors->first('password')}}</span>
                @endif    
                <div class="mdl-textfield mdl-js-textfield">
                  <input class="mdl-textfield__input" type="password" name="password_confirmation" id="password_confirm_input" />
                  <label class="mdl-textfield__label" for="password_confirm_input">Confirm Password...</label>                   
                </div>
                @if($errors->has('password_confirmation'))
                    <span>{{ $errors->first('password_confirmation')}}</span>
                @endif 
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Reset Password
                </button>
              </form>
          </div>              
        </div>
      </div>

@stop
