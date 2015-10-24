<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <title>Laravel 5.1 Boilerplate</title>
    
    @include('common.script_top')
    
</head>
<body>
    <div class="mdl-layout mdl-js-layout has-drawer is-upgraded">        
        <main class="mdl-layout__content">   
            @if(Session::has('global'))
            <div class="mdl-card">
                <p>{{ Session::get('global') }}</p>
            </div>
            @endif
            @yield('content')  
            <footer class="mdl-mini-footer">
            </footer>
        </main>                     
    </div>    
    @include('common.script_bottom')    
    @include('common.analytics_tags')    
</body>
</html>