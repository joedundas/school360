<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/7/17
 * Time: 6:16 PM
 */
class SessionManager
{


    public $cache;

    public $user;
    public $authorizations;
    public $authViewsDao;
    public $featureFlips;

    // Dto collections
    public $authViewsCollection;

    public $featureCodesCollection;
    public $featureFlipsCollection = array(); // array of collections hashed by school ID

    public $authorizationCodesCollection;
    public $authorizationsCollection = array();  // array of collections hashed by role ID

    // Repositories
    private $authViewsRepository;
    private $featureRepository;
    private $authorizationsRepository;


    public function switchToRole(RoleDto $roleDto) {

        $this->setCurrentRoleId($roleDto->getId());
        $this->setCurrentSchoolId($roleDto->getSchoolId());

        $schoolId = $roleDto->getSchoolId();
        $this->featureFlips->setFeatureCodesCollection($this->featureCodesCollection);
        $this->loadFeatureFlips($roleDto,true);
      //  echo "setting feature flips collection to school ID [" . $schoolId . "]]";
       $this->featureFlips->setFeatureFlipsCollection($this->featureFlipsCollection[$schoolId]);


       $this->authorizations->setAuthCodesCollection($this->authorizationCodesCollection);
       $this->loadAuthorizations($roleDto);
       $this->authorizations->setRoleAuthsCollection($this->authorizationsCollection[$roleDto->getRoleId()]);


        $this->saveSessionToCache();
    }

    public function __construct( CacheControllerInterface $cache = null) {
        if($cache === null) {
            $cache = new CacheController();
        }
        $this->cache = $cache;  // finished
        $this->user = new UserDao(new UserDto()); // finished
        $this->authViewsDao = new AuthViewDao();
        $this->authorizations = new AuthorizationDao();
        $this->featureFlips = new FeatureFlipDao();
        $this->featureCodesCollection = new FeatureCodesCollection();
        $this->authorizationCodesCollection = new AuthorizationsCollection();

        $this->authViewsCollection = new AuthViewCollection();

        $this->authViewsRepository = new AuthViewRepository();
        $this->featureRepository = new FeatureRepository();
        $this->authorizationsRepository = new AuthorizationRepository();

    }

    public function loadUser($userId,$roleId = false) {
        $this->user->initiate($userId);

        if($roleId === false) {
            $roleDto = $this->user->roles()->getDefaultRoleDto();
            if ($roleDto === false) {
                //@TODO - handle where there is no default role
                throw new Exception('Could not initiate Session with a default role');
            }
        }
        else {
            $roleDto = $this->user->roles()->getById($roleId);
        }

        $this->setCurrentRoleId($roleDto->getRoleId());
        $this->setCurrentSchoolId($roleDto->getSchoolId());

        return $roleDto;
    }
    public function loadAuthViews() {
        $authViews = $this->authViewsRepository->getAuthViews();
        foreach($authViews as $idx=>$authView) {
            $dto = new AuthViewDto();
            AuthViewHydrator::hydrateAuthViewFromDB($dto,$authView);
            $this->authViewsCollection->add($dto);
        }
    }
    public function loadAuthorizations(RoleDto $role, $forceReload = false) {
        $roleId = $role->getRoleId();
        if(!is_int($roleId)) {
            throw new Exception('Must supply a valid role ID to load authorizations');
        }
        if($forceReload || !array_key_exists($roleId,$this->authorizationsCollection)) {
            $this->loadRolesAuthorizations($roleId);
        }
    }
    public function loadAuthorizationCodes() {
        $this->authorizationCodesCollection->reset();
        $authCodes = $this->authorizationsRepository->getAuthorizationCodes();
        foreach($authCodes as $idx=>$authCode) {
            $dto = new AuthorizationCodeDto();
            AuthorizationHydrator::hydrateAuthorizationDtoFromTypesDB($dto,$authCode);
            $this->authorizationCodesCollection->add($dto);
        }
        $this->authorizationCodesCollection->setAuthsLoaded(true);

    }
    public function loadFeatureCodes() {
        $this->featureCodesCollection->reset();
        $featureCodes = $this->featureRepository->getFeatureCodes();

        foreach($featureCodes as $idx=>$featureCode) {
            $dto = new FeatureCodeDto();
            FeatureFlipHydrator::hydrateFeatureCodeDtoFromDB($dto,$featureCode);
            $this->featureCodesCollection->add($dto);
        }
        $this->featureCodesCollection->setCodesLoaded(true);

    }

    public function loadFeatureFlips(RoleDto $role, $forceReload = false) {
        $schoolId = $role->getSchoolId();
        if(!is_int($schoolId)) {
            throw new Exception('Must supply a valid school ID to load feature flips');
        }

        if($forceReload || !array_key_exists($schoolId,$this->featureFlipsCollection)) {
            $this->loadSchoolsFeatureFlips($schoolId);
        }

    }
    public function loadRolesAuthorizations($roleId) {
        if(! $this->authorizationCodesCollection->isAuthsLoaded()) {
            throw new Exception('Trying to load authorizations for role prior to loading authorization codes');
        }

        $collection = new RoleAuthorizationsCollection();
        $authorizations = $this->authorizationsRepository->getRoleSpecificAuthorizations($roleId);

        foreach($authorizations as $idx=>$authorization) {
            $dto = new AuthorizationCodeRoleSpecificDto();
            AuthorizationHydrator::hydrateAuthorizationRoleSpecificDtoFromDB($dto,$authorization);
            $collection->add($dto);
        }
        $collection->setRoleAuthorizationsLoaded(true);
        $collection->setRoleId($roleId);
        $this->authorizationsCollection[$roleId] = $collection;
    }

    public function loadSchoolsFeatureFlips($schoolId) {

        if(! $this->featureCodesCollection->isCodesLoaded()) {
            throw new Exception('Trying to load schools feature flips prior to loading feature codes');
        }
        $collection = new FeatureFlipsCollection();

        $featureFlips = $this->featureRepository->getFeatureFlipsForSchoolId($schoolId);

        foreach($featureFlips as $idx=>$featureFlip) {
            $dto = new FeatureFlipDto();
            FeatureFlipHydrator::hydrateFeatureFlipDtoFromFeatureFlipDB($dto,$featureFlip);
            $collection->add($dto);
        }
        $collection->setSchoolFeatureFlipsLoaded(true);
        $collection->setSchoolId($schoolId);

        $this->featureFlipsCollection[$schoolId] = $collection;

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
            'authViews'=>serialize($this->authViewsCollection),
           'authorizationCodes'=>serialize($this->authorizationCodesCollection),
           'authorizations'=>serialize($this->authorizationsCollection),
           // 'authorizations'=>serialize($this->authorizations),
            'featureFlips'=>serialize($this->featureFlipsCollection),
            'featureCodes'=>serialize($this->featureCodesCollection)
        );
        $this->cache->save($items);
    }
    public function reviveSessionFromCache() {
        $this->user->setDto(unserialize($this->cache->get('userDto')));
        $this->authViewsCollection = unserialize($this->cache->get('authViews'));
        $this->setCurrentRoleId($this->cache->get('currentRoleId'));
        $this->setCurrentSchoolId($this->cache->get('currentSchoolId'));

        $this->featureCodesCollection = unserialize($this->cache->get('featureCodes'));
        $this->featureFlips->setFeatureCodesCollection($this->featureCodesCollection);

        $loadFeatureFlipsFromCache = \Edu3Sixty\SettingsController::getStatus('feature-flip-cache',$this->user->getUserId(),$this->getCurrentSchoolId(),$this->getCurrentRoleId());
        if($loadFeatureFlipsFromCache === 'on') {
            $this->featureFlipsCollection = unserialize($this->cache->get('featureFlips'));
        }
        else {
            $this->loadFeatureFlips($this->user->getCurrentRoleDto());
        }

        $this->featureFlips->setFeatureFlipsCollection($this->featureFlipsCollection[$this->getCurrentSchoolId()]);

        $this->authorizationCodesCollection = unserialize($this->cache->get('authorizationCodes'));
        $loadAuthorizationsFromCache = \Edu3Sixty\SettingsController::getStatus('auth-cache',$this->user->getUserId(),$this->getCurrentSchoolId(),$this->getCurrentRoleId());
        if($loadAuthorizationsFromCache === 'on') {
            $this->authorizationsCollection = unserialize($this->cache->get('authorizations'));
        }
        else {
            $this->loadAuthorizations($this->user->getCurrentRoleDto());
        }
        $this->authorizations->setAuthCodesCollection($this->authorizationCodesCollection);
        $this->authorizations->setRoleAuthsCollection($this->authorizationsCollection[$this->getCurrentRoleId()]);
        //$this->authorizations->setDto(unserialize($this->cache->get('authorizations')));
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