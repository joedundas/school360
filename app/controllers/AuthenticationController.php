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
            $SessionManager = new SessionManager(
                new CacheController()
            );
            $roleDto = $SessionManager->loadUser(Auth::user()->id);
            $SessionManager->loadAuthViews();
//            $SessionManager->loadAuthorizations();
            $SessionManager->loadFeatureCodes();
            $SessionManager->loadFeatureFlips($roleDto);
            $SessionManager->switchToRole($roleDto);
            $SessionManager->saveSessionToCache();

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
