<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 12:57 PM
 */
class UserDao
{

    private $dto = null;
    private $repository = null;

    public function __construct(UserDto $dto,UserRepository $repository = null)
    {
        $this->setDto($dto);
        if($repository !== null) {
            $this->repository = $repository;
        }
        else {
            $this->repository = new UserRepository();
        }

    }

    public function name() {
        // returns the roles name value object if it has been set.  If not set, then it
        //   returns the users name value object.
        $role = $this->roles()->getById($this->getCurrentRoleId());
        return $role->getName()->hasBeenSet() ? $role->getName() : $this->dto->getName();
    }
    public function roles() {
        return $this->dto->roles;
    }
    public function schools() {
        return $this->dto->schools;
    }
    public function initiate($userId) {
        if($this->getDto() === null) {
            throw new Exception('User DAO must have User DTO set prior to hydrating from database');
        }
        $this->dto->setUserId($userId);

        UserHydrator::hydrateUserSchoolsFromDB($this->dto);

        UserHydrator::hydrateUserAndRolesromDB(
            $this->dto,
            $this->repository->getUserAndRoles($this->dto->getUserId())
        );
        UserHydrator::hydrateContactInfoResultsIntoUserDto(
            $this->dto,
            $this->repository->getUsersContactInformation($this->dto->getUserId())
        );



        $demographicsResults = $this->repository->getUserDemographics($this->dto->getUserId());
        foreach($demographicsResults as $idx=>$result) {

        }

    }

    public function getCurrentRoleDto() {
        return $this->roles()->getById($this->getCurrentRoleId());
    }

    public function getUserId() {
        return $this->dto->getUserId();
    }
    public function setCurrentRoleId($roleId) {
       $this->dto->setCurrentRoleId($roleId);
    }
    public function getCurrentRoleId() {
        return $this->dto->getCurrentRoleId();
    }
    public function setCurrentSchoolId($schoolId) {
        $this->dto->setCurrentSchoolId($schoolId);
    }
    public function getCurrentSchoolId() {
        return $this->dto->getCurrentSchoolId();
    }
    public function getCurrentSchoolDto() {
        return $this->dto->schools->getById($this->getCurrentSchoolId());
    }
    public function setRepository(UserRepository $repo) {
        $this->repository = $repo;
    }
    public function getRepository() {
        return $this->repository;
    }

    public function setDto(UserDto $dto) {
        $this->dto = $dto;
    }
    public function getDto() {
        return $this->dto;
    }

}