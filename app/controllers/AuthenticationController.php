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

            $this->createNewSession(
                new SessionManager(new CacheController())
            );
        }
        else {
            $response->insertGlobalErrors(array('Could not authenticate user'));
        }
         return Response::make($response->toJson());
    }

    public function refreshSession() {
        $currentSession = new SessionManager();
        $currentSession->reviveSessionFromCache();
        $currentRoleDto = $currentSession->user->getCurrentRoleDto();

        $SessionManager = $this->createNewSession(new SessionManager(new CacheController()));
        $SessionManager->switchToRole($currentRoleDto);
    }
    public function createNewSession(SessionManager $SessionManager) {

        //$SessionManager->cache->flush();
        $roleDto = $SessionManager->loadUser(Auth::user()->id);
        $SessionManager->loadAuthViews();
//            $SessionManager->loadAuthorizations();
        $SessionManager->loadFeatureCodes();
        $SessionManager->loadFeatureFlips($roleDto);
        $SessionManager->switchToRole($roleDto);
        $SessionManager->saveSessionToCache();
        return $SessionManager;
    }

    public function doLogout() {
        $sessionManager = new SessionManager();
        $sessionManager->reviveSessionFromCache();
        $sessionManager->cache->flush(true);

        Auth::logout();
        return Redirect::to('login');
    }

}
