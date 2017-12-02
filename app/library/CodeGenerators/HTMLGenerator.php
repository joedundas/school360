<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/30/17
 * Time: 1:07 PM
 */
class HTMLGenerator
{


    static public function createUserRoleCard($userRoleId, userDTO $userDto,$params = array()) {

        $clickToLogin = isset($params['login']) ? $params['login'] : true;
        $showSchoolName = isset($params['showSchool']) ? $params['showSchool'] : false;

        $roleInfo = $userDto->getRoleByUserRoleId($userRoleId);


        $cardHtml = '
    <div class="col-md-12 col-sm-12 col-xs-12 profile_details" ';
        if($clickToLogin) {
            $cardHtml .= 'onclick="controller.page.switchToRole(' . $userRoleId . ')"';
        }
        $cardHtml .= '>
        <div class="well profile_view">
            <div class="col-sm-12">
            ';
        if($showSchoolName) {
            $schools = $userDto->getSchoolsArray();
            $schoolId = $roleInfo['schoolId'];
            $schoolName = $schools[$schoolId]['name'];
            $cardHtml .= '<h4 class="brief"><i><b>'  . $schoolName. '</b></i></h4>';
        }

        $about = $userDto->getDemographicsItemForUserRole($userRoleId,'about');
        $email = $userDto->getDefaultEmailForUserRole($userRoleId);
        //var_dump($email);
        $cardHtml .= '
            
                <h4 class="brief"><i>'  . Formatter::roleType($roleInfo['role']) . '</i></h4>
                <div class="left col-xs-7">
                    <h2>' . Formatter::personName($userDto->getNameArray(),'%P %F %m %L %S') . '</h2>
                    <p><strong>About: </strong> ' . $about . '</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-building"></i> Address: </li>
                        <li><i class="fa fa-phone"></i> Phone #: ' . ''. '</li>
                        <li><i class="fa fa-envelope"></i> Email: ' . $email . '</li>
                    </ul>
                </div>
                <div class="right col-xs-5 text-center">
                    <img src="images/img.jpg" alt="" class="img-circle img-responsive">
                </div>
            </div>
        </div>
    </div>
    ';

        return $cardHtml;
    }
}