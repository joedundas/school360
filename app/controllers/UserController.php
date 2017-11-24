<?php


use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    private $user;

    public function __construct() {

    }



    public function getUserFromSession() {
        $response = DependencyInjection::ApiResponse();
        $userDto = unserialize(Session::get('user'));

        $response->addPassback($userDto->toArray());
        return Response::make($response->toJson());

    }
    public function loadUserToSession() {
        $userId = Auth::user()->id;
        $userDto = new userDto();
//        $this->getUserInformation($userDto,$userId);
        Session::put('user',
            serialize($userDto)
        );
        return $userDto;
    }


    public function getUserInformation(userDto &$userDto,$userId = '') {
        if($userId == '') { $userId = Auth::user()->id; }

        $user = new User();
        $userName = $user->find($userId);
        $userDto->setUserId($userId);
        $userDto->setFirstName($userName->firstName);
        $userDto->setLastName($userName->lastName);
        $userDto->setImage('img.jpg');

        $userInformation = UserInformation::where('userId','=',$userId)->get();
        if(! $userInformation->isEmpty()) {
            $userInformation = $userInformation[0];
            $birthdate = $userInformation->birthdate;
            $userDto->setGender($userInformation->gender);
            if($birthdate != '' && $birthdate != '0000-00-00') {
                $userDto->setBirthdate($birthdate->format('m/d/Y'));
            }
        }
        return $userDto;
    }
    static public function saveUserToSession($userInfo) {
        Session::put('user',$userInfo);
    }




}