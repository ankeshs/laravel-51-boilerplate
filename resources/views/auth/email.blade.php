@extends('layout.main')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-card mdl-shadow--4dp mdl-cell mdl-cell--12-col">
          <div class="mdl-card__media mdl-color-text--grey-50">
            <h3>Forgot Password</h3>
          </div>              
          <div class="mdl-color-text--grey-700 mdl-card">
              <form action="{{ action('Auth\AuthController@postEmailLogin') }}" method="post">
                <div class="mdl-textfield mdl-js-textfield">
                  <input class="mdl-textfield__input" type="text" name="email" id="email_input" value="{{ Input::old('email') }}" />
                  <label class="mdl-textfield__label" for="email_input">Email Address...</label>                   
                </div>
                @if($errors->has('email'))
                    <span>{{ $errors->first('email')}}</span>
                @endif                     
                {!! csrf_field() !!}
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                    Send Magic Login Link
                </button>
              </form>
          </div>              
        </div>
      </div>

@stop
