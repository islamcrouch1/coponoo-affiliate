<?php

use Illuminate\Support\Facades\Route;

use Twilio\Rest\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/test123', function () {




    $code = random_int(100000, 999999);



    $client = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

    $client->messages->create(
        '+201121184148', // to
        ["body" => "Your Coponoo Verification Code Is : {$code}", "from" => "Twilio"]
    );
});



Route::redirect('/', 'ar/homepage');

Route::redirect('/ar', 'ar/homepage');



Route::group(['prefix' => '{lang}'], function () {

    Route::get('/homepage', 'HomeController@index')->name('home.front');
    Route::get('/contact-us', 'HomeController@contact')->name('contact.front');
    Route::get('/our-products', 'HomeController@products')->name('contact.products');
    Route::get('/about-coponoo', 'HomeController@about')->name('contact.about');
    Route::get('/terms-conditions', 'HomeController@terms')->name('front.terms');


    Auth::routes();
});
