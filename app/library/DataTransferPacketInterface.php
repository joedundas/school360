<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 1/10/18
 * Time: 9:33 AM
 */
interface DataTransferPacketInterface
{
    public function getRoute();
    public function getClass();
    public function getMethod();
    public function setResults($results);
    public function setInputData($input);
    public function getInputData();
}