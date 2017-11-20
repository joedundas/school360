<?php



class AuthenticationController extends BaseController {

    public function __construct() {

    }
    public function login() {
        $data = Input::all();
        $response = DependencyInjection::ApiResponse();
        $userdata = array(
            'email'=>Input::get('data.email'),
            'password'=>Input::get('data.password')
        );
        if(Auth::attempt($userdata)) {
            $userType = UserMapper::getUserTypeBasedOnIdArray(
              UserMapper::getUserTypeArrayFromAuthUserModel(Auth::user()->toArray())
            );
            $userDto = UserRepository

////            $userController = new UserController();
////            $userController->loadUserToSession();
////
////            $settingsController = new SettingsController();
////            $settingsController->getUserSettings();
//
//
        }
        else {
            echo "Did not find you dude!!";
        }
//        else {
//            $response->insertGlobalErrors(array('Could not authenticate user'));
//        }
//        return Response::make($response->toJson());
    }

    public function doLogout() {
        Auth::logout();
        return Redirect::to('login');
    }

}
