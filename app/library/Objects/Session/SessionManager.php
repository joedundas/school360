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
    public $authorizationsDao;
    public $authViewsDao;
    public $featureFlips;

    // Dto collections
    public $authViewsCollection;
    public $featureCodesCollection;
    public $featureFlipsCollection = array(); // array of collections hashed by school ID

    // Repositories
    private $authViewsRepository;
    private $featureRepository;



    public function switchToRole(RoleDto $roleDto) {

        $this->setCurrentRoleId($roleDto->getId());
        $this->setCurrentSchoolId($roleDto->getSchoolId());

        $schoolId = $roleDto->getSchoolId();
        $this->featureFlips->setFeatureCodesCollection($this->featureCodesCollection);
        $this->loadFeatureFlips($roleDto,true);
      //  echo "setting feature flips collection to school ID [" . $schoolId . "]]";
       $this->featureFlips->setFeatureFlipsCollection($this->featureFlipsCollection[$schoolId]);
   //     var_dump($this->featureFlipsCollection[$schoolId]);

        $this->saveSessionToCache();
    }

    public function __construct( CacheControllerInterface $cache = null) {
        if($cache === null) {
            $cache = new CacheController();
        }
        $this->cache = $cache;  // finished
        $this->user = new UserDao(new UserDto()); // finished
        $this->authViewsDao = new AuthViewDao();
        $this->authorizationsDao = new AuthorizationDao();
        $this->featureFlips = new FeatureFlipDao();
        $this->featureCodesCollection = new FeatureCodesCollection();

        $this->authViewsCollection = new AuthViewCollection();

        $this->authViewsRepository = new AuthViewRepository();
        $this->featureRepository = new FeatureRepository();

    }

    public function loadUser($userId) {
        $this->user->initiate($userId);
        $defaultRoleDto = $this->user->roles()->getDefaultRoleDto();

        if($defaultRoleDto === false) {
            //@TODO - handle where there is no default role
            throw new Exception('Could not initiate Session with a default role');
        }

        $this->setCurrentRoleId($defaultRoleDto->getRoleId());
        $this->setCurrentSchoolId($defaultRoleDto->getSchoolId());

        return $defaultRoleDto;
    }
    public function loadAuthViews() {
        $authViews = $this->authViewsRepository->getAuthViews();
        foreach($authViews as $idx=>$authView) {
            $dto = new AuthViewDto();
            AuthViewHydrator::hydrateAuthViewFromDB($dto,$authView);
            $this->authViewsCollection->add($dto);
        }
    }
    public function loadAuthorizations() {
        $userId = $this->user->getUserId();
        if(!$userId || ! ($userId > 0)) {
            throw new Exception('Session Manage cannot initate authorizations without a user ID');
        }
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
       // echo "++[" . $loadFeatureFlipsFromCache . "]++";
        if($loadFeatureFlipsFromCache === 'on') {
            $this->featureFlipsCollection = unserialize($this->cache->get('featureFlips'));
        }
        else {
            $this->loadFeatureFlips($this->user->getCurrentRoleDto());
        }

        $this->featureFlips->setFeatureFlipsCollection($this->featureFlipsCollection[$this->getCurrentSchoolId()]);

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