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
            $userType = UserMapper::getUserTypeBasedOnIdArray(
              UserMapper::getUserTypeArrayFromAuthUserModel(Auth::user()->toArray())
            );
            $userDto = UserFactory::createDTO($userType);
            $userDto->hydrate(Auth::user()->id);


            $currentSchoolId = null;
            $currentSchoolDTO = null;
            $schools = $userDto->getSchoolsArray();
            if(count($schools) == 0) {
                //@TODO handle if there is no school
                echo "No School Associated with this user";
                exit;
            }
            elseif(count($schools) == 1) {
                $currentSchoolId = $schools[0]['schoolId'];
            }
            else {
                $currentSchoolId = $userDto->getDefaultSchoolId();
            }

            if($currentSchoolId === null) {
                throw new Exception('Could not find school ID associated with user ' . Auth::user()->id . ')  upon authentication AuthenticationController@login');
            }
            $schoolDTO = new schoolDTO();
            $schoolDTO->hydrate($currentSchoolId);

            userController::saveUserToSession($userDto->asArray());
            Session::put('currentSchool',$schoolDTO->asArray());

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
