<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/24/17
 * Time: 12:44 PM
 */
class AbstractAuthorizationDTO
{

    protected $authorizationCodes = array();
    protected $authorizationRepository;

    public function __construct() {
        $this->authorizationRepository = new authorizationRepository();
        $this->createAuthorizationCodesArray($this->authorizationRepository->getAuthorizationCodes());
    }
    private function createAuthorizationCodesArray($codes) {
        foreach($codes as $idx=>$code) {
            $this->authorizationCodes[$code['permissionCode']] = $code;
        }
    }
}