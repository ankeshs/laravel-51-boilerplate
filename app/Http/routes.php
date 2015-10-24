<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {    
        return view('welcome');
    });
});

/* Route::get('/test-mail', function(){
    $emails = ['ank.singh90@gmail.com', 'ankesh.singh@timesinternet.in', 'anik8.roy@gmail.com'];
    Mail::send('emails.recipt', [], function($message) use($emails) {
        $message->to($emails)->subject('Test recipt');
    });
    //var_dump(Mail::failures());
    return View::make('emails.recipt');
}); */

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
