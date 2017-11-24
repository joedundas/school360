<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/21/17
 * Time: 10:02 AM
 */
interface UserRepositoryInterface
{
    static public function performQuery($query);
    public function getSingleUserByUserId($userId);
}