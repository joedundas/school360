<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:15 AM
 */
class AbstractAuthorizationRepository extends AbstractRepository
{
    protected $query;

    public function getAuthorizationCodes() {
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $this->query = DB::table('authorization_types');
        $this->query->orderBy('entryOrder','asc');
        return self::performQuery($this->query);
        DB::setFetchMode(PDO::FETCH_CLASS);
    }
}