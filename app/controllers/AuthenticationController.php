<?php



class AuthenticationController extends BaseController {

    public function __construct() {

    }

    public function tester(DataTransferPacketInterface $packet) {
            return array();
    }
    public function login(DataTransferPacketInterface $packet) {
        $input = $packet->getInputData();

        $userdata = array(
            'email'=>$input['email'],
            'password'=>$input['password'],
            'canLogin'=>'Y'
        );
        $packet->removeInputByKey('password');
        Session::flush();
        if(Auth::attempt($userdata)) {
            $this->createNewSession(
                new SessionManager(new CacheController())
            );
        }
        else {
            $packet->addError('Could not authenticate user','server');
        }
        return array();

    }
    public function switchToRole(DataTransferPacketInterface $packet) {
        //$input = Input::all();
        $data = $packet->getInputData();

        $currentSession = new SessionManager();
        $currentSession->reviveSessionFromCache();
        $roleDto = $currentSession->user->roles()->getById($data['roleId']);
        $currentSession->switchToRole($roleDto);
        return json_encode(array('a','b'));

    }
    public function refreshSession(DataTransferPacketInterface $packet) {

        $currentSession = new SessionManager();
        $currentSession->reviveSessionFromCache();
        $currentRoleDto = $currentSession->user->getCurrentRoleDto();
        //$packet->setInputData(array('roleId'=>$currentRoleDto->getRoleId()));
        $SessionManager = $this->createNewSession(new SessionManager(new CacheController()),$currentRoleDto->getRoleId());
        //$SessionManager->switchToRole($packet);


//
//        return json_encode(array('a','b'));
    }
    public function createNewSession(SessionManager $SessionManager, $roleId = false) {

        $SessionManager->cache->flush();
        $roleDto = $SessionManager->loadUser(Auth::user()->id,$roleId);
//        if($roleId !== false) {
//            echo "[[" . $roleId . "]]";
//        }
        $SessionManager->loadAuthViews();
//            $SessionManager->loadAuthorizations();
        $SessionManager->loadFeatureCodes();
        $SessionManager->loadFeatureFlips($roleDto);

        $SessionManager->loadAuthorizationCodes();
        $SessionManager->loadAuthorizations($roleDto);

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
