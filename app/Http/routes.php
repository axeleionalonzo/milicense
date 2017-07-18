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


/*
|
| Page routing
|
*/
// Landing page for GUEST users
// Route::get('/', 'WelcomeController@index');
Route::get('/', function() {
	return view('welcome');
});

// Landing page for REGISTERED users
Route::get('license', 'LicenseController@index');
Route::get('auth/login', function() {
	return view('auth/login');
});


/*
|
| Authentication
|
*/
// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);


/*
|
| API calls for Angular updates
|
*/
// // Route::resource('api/license','ApiLicenseController');
// Route::group(array('prefix' => 'api'), function() {

//     // since we will be using this just for CRUD, we won't need create and edit
//     // Angular will handle both of those forms
//     // this ensures that a user can't access api/create or api/edit when there's nothing there
//     Route::resource('license', 'ApiLicenseController');
//     // Route::resource('imei', 'ImeiController');
// });

// // Catch for invalid routes
// // Redirects to the welcome page
// // Route::any('{catchall}', 'WelcomeController@index')->where('catchall', '(.*)');
// /*
// |
// | Route everything else to the Angular page - angular will handle the routing
// | App::missing no longer supported - how best to trap this routing and render the 'ng' view/page
// */