<?php

Route::get('login', function()
{
    return View::make('login');
});
Route::match(array('GET','POST'),'customer/list/{search?}',array('before'=>'auth', function($search='') {
    return View::make('secure.personas.list',array('persona'=>'customer','search'=>$search));
}));

Route::match(array('GET','POST'),'courses/list/{search?}',array('before'=>'auth', function($search='') {
    return View::make('secure.courses.list',array('persona'=>'customer','search'=>$search));
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

Route::match(array('GET','POST'),'modal/{view}',array('before'=>'auth', function($view) {
    //$data = (new ModalViewController)->getModalView($view);
    return (new ModalViewController)->getModalView($view); //(new ApiController($class,$method,Input::all()))->call();
}));


Route::match(array('GET','POST'),'secure/api/{class}/{method}',array('before'=>'auth', function($class,$method) {

    $DTP = DependencyInjection::DataTransferPacket();
    $DTP->loadFromReceivedAjaxCall(Input::all(),$class,$method);

    return (new ApiController($DTP))->call();
}));
Route::match(array('GET','POST'),'api/{class}/{method}',array(function($class,$method) {
    $DTP = DependencyInjection::DataTransferPacket();
    $DTP->loadFromReceivedAjaxCall(Input::all(),$class,$method);
    return (new ApiController($DTP))->call();
}));
Route::match(array('GET','POST'),'ajax/{class}/{method}',array(function($class,$method) {
    $DTP = DependencyInjection::DataTransferPacket();
    $DTP->loadFromReceivedAjaxCall(Input::all(),$class,$method);
    return (new ApiController($DTP))->call();
}));
Route::match(array('GET','POST'),'public/{class}/{method}',array(function($class,$method) {
    $DTP = DependencyInjection::DataTransferPacket();
    $DTP->loadFromReceivedAjaxCall(Input::all(),$class,$method);
    return (new ApiController($DTP))->call();
}));


Route::match(array('GET','POST'),'doLogout','AuthenticationController@doLogout');
//Route::match(array('GET','POST'),'switchRole',array('before'=>'auth', 'uses'=>'AuthenticationController@switchToRole'));
//Route::match(array('GET','POST'),'session/refresh',array('before'=>'auth', 'uses'=>'AuthenticationController@refreshSession'));
//// AJAX Responses
//Route::get('utilities/stateList/{searchTerm?}','AjaxController@getListOfStates');







