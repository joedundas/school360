<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:27 AM
 */
class AbstractRepository
{
    static public function performQuery($query,$resultsType = 'FETCH_CLASS') {
        if($resultsType == 'FETCH_ASSOC') {
            DB::setFetchMode(PDO::FETCH_ASSOC);
        }
        else {
            DB::setFetchMode(PDO::FETCH_CLASS);
        }
        return $query->get();
        DB::setFetchMode(PDO::FETCH_CLASS);
    }
}