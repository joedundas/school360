<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/20/17
 * Time: 12:41 PM
 */
abstract class AbstractUserRepository extends AbstractRepository implements UserRepositoryInterface
{


    public function getSingleUserByUserId($userId) {
        $userTypeInformation = UserMapper::getUserTypeInformation($this->userType);
        $dbIdentifier = $userTypeInformation['id'];
        $this->query = DB::table('users');
        $this->query->leftJoin($this->userType,"users." . $dbIdentifier,"=",$this->userType . ".id");
        $this->query->select(array('users.id as userId','users.email as email',$this->userType . '.*'));
        $this->query->where('users.id','=',$userId);
        return self::performQuery($this->query);
    }
}