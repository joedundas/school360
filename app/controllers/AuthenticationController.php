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

            $userDto = new userDTO();
            $userDto->hydrate(Auth::user()->id);


            $currentSchoolId = $userDto->getDefaultSchoolId();
            if(!$currentSchoolId) {
                //@TODO Handle when there is not a default school found
                throw new Exception('Could not find a default school ID');
            }
            $currentUserRoleId = $userDto->getDefaultRoleIdForSchoolId($currentSchoolId);
            if(!$currentUserRoleId) {
                //@TODO
                // Handle when there is not default user role ID.  I do not think this is reachable,
                // because school ID would be false.
                throw new Exception('Could not find a default user role ID for school ID [' . $currentSchoolId . ']');
            }
            $userDto->setCurrentSchoolId($currentSchoolId);
            $userDto->setCurrentUserRoleId($currentUserRoleId);

            $schoolDTO = new schoolDTO();
            $schoolDTO->hydrate($currentSchoolId);
//
//            $authorizationController = new AuthorizationController();
//            $authorizationController->setAuthorizationForUserIdAtSchoolIdAsUserType($userDto,$schoolDTO);
//            userController::saveUserToSession($userDto->asArray());
//            Session::put('currentSchool',$schoolDTO->asArray());

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
