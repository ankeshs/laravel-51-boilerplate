<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>        
        <p>Hi {{$email}}, </p>
        <p>
            To activate your account, click <a href="{{ $activation_url }}">here</a>.
        </p>            
        <p> Or copy paste this url: {{ $activation_url }} </p>        
    </body>
</html>
