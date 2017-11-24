<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/23/17
 * Time: 10:27 AM
 */
class AbstractRepository
{
    static public function performQuery($query) {
            return $query->get();
    }
}