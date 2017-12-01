<?php

Route::get('login', function()
{
    return View::make('login');
});

//Route::get('secure', function()
//{
//    return View::make('secure/index');
//});

Route::get('secure', array('before'=>'auth', function() {
    return View::make('secure/index');
}));

Route::match(array('GET','POST'),'dashboard',array('before'=>'auth',function() {
    $bladeFile = 'secure.dashboard.admin.layout';
    return View::make($bladeFile);
}));

Route::match(array('GET','POST'),'modal/{view}','ModalViewController@getModalView');

//
//Route::match(array('GET','POST'),'modal/{view}','ModalViewController@getModalView');
//
//Route::match(array('GET','POST'),'admin/account/settings/labels',array('before'=>'auth', function() {
//    return PageTextController::processText(View::make('secure.admin.account.settings.labels'));
//}));
//
//Route::match(array('GET','POST'),'dashboard',array('before'=>'auth', function() {
//    $bladeFile = 'secure.dashboard.admin.layout';
//    return View::make($bladeFile);
//}));
//
//Route::match(array('GET','POST'),'exampleForms',array('before'=>'auth', function() {
//    return PageTextController::processText(View::make('secure.examples.exampleForms'));
//}));
//
//
//
Route::post('login','AuthenticationController@login');
Route::match(array('GET','POST'),'doLogout','AuthenticationController@doLogout');
Route::match(array('GET','POST'),'switchRole',array('before'=>'auth', 'uses'=>'AuthenticationController@switchToRole'));

//// AJAX Responses
//Route::get('utilities/stateList/{searchTerm?}','AjaxController@getListOfStates');







