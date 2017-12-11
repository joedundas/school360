<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/27/17
 * Time: 12:44 PM
 */
class AuthViewRepository extends AbstractRepository
{
    private $query;

    public function getAuthViews() {
        $this->query = DB::table('authorization_views');
        return self::performQuery($this->query,'FETCH_ASSOC');
    }
}