<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 6:16 PM
 */
class SessionDao
{


    public $cache;

    public $user;
    public $authorizations;
    public $authViews;
    public $featureFlips;

    public function __construct( CacheControllerInterface $cache = null) {
        if($cache === null) {
            $cache = new CacheController();
        }
        $this->cache = $cache;
        $this->user = new UserDao(new UserDto());
        $this->authViews = new AuthViewDao();
        $this->authorizations = new AuthorizationDao();
        $this->featureFlips = new FeatureFlipDao();
    }

    public function initiate($userId) {
        $this->user->initiate($userId);
        $defaultRoleDto = $this->user->roles()->getDefaultRoleDto();

        if($defaultRoleDto === false) {
            //@TODO - handle where there is no default role
            throw new Exception('Could not initiate Session with a default role');
        }

        $this->setCurrentRoleId($defaultRoleDto->getRoleId());
        $this->setCurrentSchoolId($defaultRoleDto->getSchoolId());

    }

    public function getNumberOfRoles() {
        //@TODO this should be somewhere else (roles)
        return 3;
    }

    public function saveSessionToCache() {
        $items = array(
            'currentRoleId'=>$this->getCurrentRoleId(),
            'currentSchoolId'=>$this->getCurrentSchoolId(),
            'userDto'=>serialize($this->user->getDto()),
            'authViewsDto'=>serialize($this->authViews->getDto()),
            'authorizations'=>serialize($this->authorizations->getDto()),
            'featureFlips'=>serialize($this->featureFlips->getDto())
        );
        $this->cache->save($items);
    }
    public function reviveSessionFromCache() {
        $this->user->setDto(unserialize($this->cache->get('userDto')));
        $this->authViews->setDto(unserialize($this->cache->get('authViewsDto')));
        $this->authorizations->setDto(unserialize($this->cache->get('authorizations')));
        $this->featureFlips->setDto(unserialize($this->cache->get('featureFlips')));
        $this->setCurrentRoleId($this->cache->get('currentRoleId'));
        $this->setCurrentSchoolId($this->cache->get('currentSchoolId'));
        return $this;
    }

    public function setCurrentRoleId($roleId) {
        $this->user->setCurrentRoleId($roleId);
    }
    public function getCurrentRoleId() {
        return $this->user->getCurrentRoleId();
    }
    public function setCurrentSchoolId($schoolId) {
        $this->user->setCurrentSchoolId($schoolId);
    }
    public function getCurrentSchoolId() {
        return $this->user->getCurrentSchoolId();
    }
}