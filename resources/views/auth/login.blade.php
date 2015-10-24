@extends('layout.main')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-card mdl-shadow--4dp mdl-cell mdl-cell--12-col">
          <div class="mdl-card__media mdl-color-text--grey-50">
            <h3>Sign In</h3>
          </div>              
          <div class="mdl-color-text--grey-700 mdl-card">
              <form action="{{ action('Auth\AuthController@postLogin') }}" method="post">
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
                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
                    <input type="checkbox" id="checkbox_remember" class="mdl-checkbox__input" checked name="remember" />
                    <span class="mdl-checkbox__label">Remember me</span>
                </label>                
                <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}" />
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Login
                </button>
              </form>
          </div>              
        </div>
      </div>

@stop