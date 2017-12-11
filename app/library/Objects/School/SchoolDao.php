<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 1:47 PM
 */
class SchoolDao
{

    private $dto = null;
    private $repository = null;

    public function __construct(SchoolRepository $repository = null) {
        if($repository !== null) {
            $this->repository = $repository;
        }
        else {
            $this->repository = new UserRepository();
        }
    }
    public function setDto($dto) {
        $this->dto = $dto;
    }
    public function hydrate_fromDB($schoolId) {
        $queryResult = $this->schoolRepository->getSingleSchoolById($schoolId);
        $this->mapper->mapQueryResultToDTO(
            $queryResult[0],
            $this
        );
    }
    public function hydrate_fromArray($array) {
        $this->setSchoolId($array['schoolId']);
        $this->setName($array['schoolName']);
        list($street,$street2,$city,$state,$zip) = $array['address'];
        $this->setPrimaryAddress($street,$street2,$city,$state,$zip);
    }
}