<?php



class AuthenticationController extends BaseController {

    public function __construct() {

    }

    public function tester(array $input) {

        $response = DependencyInjection::ApiResponse();
        $response->addPassback($input);
        return $response;

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
         return $response->toJson();
    }
    public function switchToRole() {
        $input = Input::all();
        $data = $input['data'];

        $currentSession = new SessionManager();
        $currentSession->reviveSessionFromCache();
        $roleDto = $currentSession->user->roles()->getById($data['roleId']);
        $currentSession->switchToRole($roleDto);

    }
    public function refreshSession() {
        $currentSession = new SessionManager();
        $currentSession->reviveSessionFromCache();
        $currentRoleDto = $currentSession->user->getCurrentRoleDto();

        $SessionManager = $this->createNewSession(new SessionManager(new CacheController()));
        $SessionManager->switchToRole($currentRoleDto);
        $response = DependencyInjection::ApiResponse();
        $response->addPassback(array('a'=>'b'));
        return $response;
    }
    public function createNewSession(SessionManager $SessionManager) {

        $SessionManager->cache->flush();
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
