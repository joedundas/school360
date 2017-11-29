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
            $userDto->hydrate_fromDB(Auth::user()->id);


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

            $schoolDto = new schoolDTO();
            $schoolDto->hydrate_fromDB($currentSchoolId);

            $authorizationDto = new AuthorizationDTO();
            $authorizationDto->hydrate_fromDB($userDto);
            $stuff = $authorizationDto->asArray();

            $authViewDto = new AuthViewDTO();
            $authViewDto->hydrate_fromDB();


            userController::saveUserToSession($userDto->asArray());
            Session::put('currentSchool',$schoolDto->asArray());
            Session::put('authorization',$authorizationDto->asArray());
            Session::put('authorizationViews',$authViewDto->asArray());

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
