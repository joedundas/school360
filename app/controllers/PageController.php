<?php



class PageController extends BaseController {

    protected $userDto;
    protected $authDto;
    protected $schoolDto;
    protected $authViewDto;

    public function __construct($userDto,$schoolDto,$authDto,$authViewDto) {
        $this->setUserDto($userDto);
        $this->setSchoolDto($schoolDto);
        $this->setAuthDto($authDto);
        $this->setAuthViewDto($authViewDto);
    }

    public function loadSessionInfo() {
        $this->userDto->hydrate_fromArray(Session::get('user'));
        $this->schoolDto->hydrate_fromArray(Session::get('currentSchool'));
        $this->authDto->hydrate_fromArray(Session::get('authorization'),$this->userDto);
        if(! $this->authDto->isUserRoleSpecificAuthorizationSet()) {
            throw new Exception('Security Protection: Authorization not set in index view');
        }
        $this->authViewDto->hydrate_fromArray(Session::get('authorizationViews'));
    }

    public function getCurrentUserRoleCode() {
        return $this->userDto->getCurrentUserRole();
    }
    public function getCurrentSchoolName() {
        return $this->schoolDto->getName();
    }
    public function getUsersName($format = false) {
        $nameArray = $this->userDto->getNameArray();
        return Formatter::personName($nameArray,$format);
    }


    public function getUserDto() {
        return $this->userDto;
    }
    public function getAuthDto() {
        return $this->authDto;
    }
    public function getSchoolDto() {
        return $this->schoolDto;
    }
    public function getAuthViewDto() {
        return $this->authViewDto;
    }
    public function canUserAccess($itemCode) {
        return $this->authViewDto->canUserAccess($itemCode,$this->authDto);
    }
    public function setUserDto($dto) {
        $this->userDto = $dto;
    }
    public function setSchoolDto($dto) {
        $this->schoolDto = $dto;
    }
    public function setAuthDto($dto) {
        $this->authDto = $dto;
    }
    public function setAuthViewDto($dto) {
        $this->authViewDto = $dto;
    }

}
