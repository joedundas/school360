<?php



class AuthenticationController extends BaseController {

    public function __construct() {

    }

    public function login() {
        $response = DependencyInjection::ApiResponse();
        $userdata = array(
            'email'=>Input::get('data.email'),
            'password'=>Input::get('data.password'),
            'canLogin'=>'Y'
        );
        Session::flush();
        if(Auth::attempt($userdata)) {
            $SessionDao = new SessionDao(
                new CacheController()
            );
            $SessionDao->initiate(Auth::user()->id);
            $SessionDao->saveSessionToCache();

        }
        else {
            $response->insertGlobalErrors(array('Could not authenticate user'));
        }
         return Response::make($response->toJson());
    }

    public function doLogout() {
        Session::flush();
        Auth::logout();
        return Redirect::to('login');
    }

}
