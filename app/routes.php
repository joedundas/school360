<?php

Route::get('login', function()
{
    return View::make('login');
});
Route::match(array('GET','POST'),'customer/list/{search?}',array('before'=>'auth', function($search='') {
    return View::make('secure.personas.list',array('persona'=>'customer','search'=>$search));
}));
Route::match(array('GET','POST'),'calendar',array('before'=>'auth', function($search='') {
    return View::make('secure.scheduler.calendar',array());
}));
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


Route::match(array('GET','POST'),'api/{class}/{method}',array('before'=>'auth', function($class,$method) {
    return (new ApiController($class,$method,Input::all()))->call();
}));
Route::match(array('GET','POST'),'ajax/{class}/{method}',array('before'=>'auth', function($class,$method) {
    return (new ApiController($class,$method,Input::all()))->call();
}));
//Route::match(array('GET','POST'),'api/test',array('before'=>'auth', function() {
//    return (new ApiController('AuthenticationController@tester',Input::all()))->call();
//}));
//
//
//



Route::post('login','AuthenticationController@login');
//Route::match(array('GET','POST'),'api/test','AuthenticationController@tester');
//Route::match(array('GET','POST'),'test2','AuthenticationController@tester');
Route::match(array('GET','POST'),'doLogout','AuthenticationController@doLogout');
Route::match(array('GET','POST'),'switchRole',array('before'=>'auth', 'uses'=>'AuthenticationController@switchToRole'));
Route::match(array('GET','POST'),'session/refresh',array('before'=>'auth', 'uses'=>'AuthenticationController@refreshSession'));
//// AJAX Responses
//Route::get('utilities/stateList/{searchTerm?}','AjaxController@getListOfStates');







