<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>        
        <p>Hi {{$email}}, </p>
        <p>
            Click <a href="{{ $login_url }}">here</a> to login. Do not share this email with anyone.
        </p>            
        <p> Or copy paste this url: {{ $login_url }} </p>        
    </body>
</html>
