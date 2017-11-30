<?php



class AuthenticationController extends BaseController {

    public function __construct() {

    }
    public function switchToRole() {
        $input = Input::all();
        $data = $input['data'];
        $newUserRoleId = $data['userRoleId'];
       // echo "[[" . $newUserRoleId . "]]";
        $response = DependencyInjection::ApiResponse();
        $this->assumeRole($data['userRoleId']);

        $response->addPassback(array());
        return Response::make($response->toJson());
    }
    public function assumeRole($userRoleId,$userDto = false,$rehydrateUser = true) {

        if($userDto === false) {
            $userArray = SessionController::getFromSession('user');
            $userDto = new userDTO();
            $userDto->hydrate_fromArray($userArray);
        }

        $authenticatedUserId = Auth::user()->id;

        if($authenticatedUserId !== $userDto->getUserId()) {
            throw new Exception('Attempt to assume role that is not a role of authenticated user');
        }
        if(! $role = $userDto->getRoleByUserRoleId($userRoleId)) {
            throw new Exception('User Role ID does not exist for this User');
        }

        if($rehydrateUser) {
            $userDto->hydrate_fromDB(Auth::user()->id);
        }

        $userRoleId = $userDto->getCurrentUserRoleId();
        $schoolId = $role['schoolId'];

        $userDto->setCurrentSchoolId($schoolId);
        $userDto->setCurrentUserRoleId($userRoleId);

        $schoolDto = new schoolDTO();
        $schoolDto->hydrate_fromDB($schoolId);

        $authorizationDto = new AuthorizationDTO();
        $authorizationDto->hydrate_fromDB($userDto);

        $authViewDto = new AuthViewDTO();
        $authViewDto->hydrate_fromDB();

        $featureFlipDto = new FeatureFlipDTO();
        $featureFlipDto->hydrate_fromDB($schoolId);

        SessionController::saveToSession(
            array(
                'user'=>$userDto->asArray(),
                'currentSchool'=>$schoolDto->asArray(),
                'authorization'=>$authorizationDto->asArray(),
                'authorizationViews=>'=>$authViewDto->asArray(),
                'featureFlips'=>$featureFlipDto->asArray()
            )
        );

    }


    public function getUserDefaultUserRole($userDto) {
        $defaultSchoolId = $userDto->getDefaultSchoolId();
        if(!$defaultSchoolId) {
            //@TODO Handle when there is not a default school found
            throw new Exception('Could not find a default school ID');
        }
        $defaultUserRoleId = $userDto->getDefaultRoleIdForSchoolId($defaultSchoolId);
        if(!$defaultUserRoleId) {
            //@TODO
            // Handle when there is not default user role ID.  I do not think this is reachable,
            // because school ID would be false.
            throw new Exception('Could not find a default user role ID for school ID [' . $currentSchoolId . ']');
        }

        return $defaultUserRoleId;
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

            $userDto = new userDTO();
            $userDto->hydrate_fromDB(Auth::user()->id);

            $userRoleId = $this->getUserDefaultUserRole($userDto);
            $userDto->setCurrentUserRoleId($userRoleId);
            $this->assumeRole($userRoleId,$userDto,false);

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
