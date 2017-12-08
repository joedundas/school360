<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 7:31 PM
 */
interface CacheControllerInterface
{
    public function save($items);
    public function get($key);
}