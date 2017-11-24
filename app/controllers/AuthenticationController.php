<?php



class AuthenticationController extends BaseController {

    public function __construct() {

    }
    public function login() {
        $data = Input::all();
        $response = DependencyInjection::ApiResponse();
        $userdata = array(
            'email'=>Input::get('data.email'),
            'password'=>Input::get('data.password'),
            'canLogin'=>'Y'
        );
        Session::flush();
        if(Auth::attempt($userdata)) {
            $userType = UserMapper::getUserTypeBasedOnIdArray(
              UserMapper::getUserTypeArrayFromAuthUserModel(Auth::user()->toArray())
            );
            $userDto = UserFactory::createDTO($userType);
            $userDto->hydrate(Auth::user()->id);
            userController::saveUserToSession($userDto->asArray());

            $currentSchoolId = null;
            $currentSchoolDTO = null;
            $schools = $userDto->getSchoolsArray();
            if(count($schools) == 0) {
                //@TODO handle if there is no school
            }
            elseif(count($schools) == 1) {
                $currentSchoolId = $schools[0]['schoolId'];
            }
            else {
                //@TODO handle multiple schools associated with user
            }
            $schoolDTO = new schoolDTO();
            $schoolDTO->hydrate($currentSchoolId);
            Session::put('currentSchool',$schoolDTO->asArray());
           // $userRepository = UserFactory::createRepository($userType);
////            $userController = new UserController();
////            $userController->loadUserToSession();
////
////            $settingsController = new SettingsController();
////            $settingsController->getUserSettings();
//
//
        }
        else {
            $response->insertGlobalErrors(array('Could not authenticate user'));
        }
//        else {
//            $response->insertGlobalErrors(array('Could not authenticate user'));
//        }
         return Response::make($response->toJson());
    }

    public function doLogout() {
        Session::flush();
        Auth::logout();
        return Redirect::to('login');
    }

}
