<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 11/27/17
 * Time: 12:43 PM
 */
class AuthViewDto
{

    private $repo;


    private $authViews = false;

    public function __construct()
    {
        $this->repo = new AuthViewRepository();
    }

    public function hydrate_fromDB() {
        $results = $this->repo->getAuthViews();
        foreach($results as $idx=>$result) {
            $this->authViews[$result['item']] = array(
                'authsRequired'=>$result['authorizationsRequired'] !== 'NULL' ? json_decode($result['authorizationsRequired'],true) : 'NULL',
                'rolesRequired'=>$result['rolesRequired'] !== 'NULL' ? json_decode($result['rolesRequired']) : 'NULL',
                'rolesRestricted'=>$result['rolesRestricted'] !== 'NULL' ? json_decode($result['rolesRestricted']) : 'NULL'
            );
        }

    }

    public function hydrate_fromArray($array) {
        //var_dump($array['add_staff']);
        $this->authViews = $array;
       // var_dump($this->authViews['add_staff']);
    }

    public function asArray() {
        return $this->authViews;
    }

    public function canUserAccess($itemCode,$userAuth) {

        if($itemCode == '' || $itemCode == null || $itemCode == false) { return true; }
        if(!array_key_exists($itemCode,$this->authViews)) {
            throw new Exception('Auth Views given an invalid item code');
        }

        $currentUserRole = $userAuth->getUserRole();

        $stuff = $userAuth->asArray();

        $entry = $this->authViews[$itemCode];
        if(is_array($entry['authsRequired'])) {
            foreach($entry['authsRequired'] as $idx=>$authcode) {
                $userAuthorizationForCode = $userAuth->getUserAuthorizationForCode($authcode);
                if($userAuthorizationForCode === 'N') {
                    return false;
                }
            }
        }
        if(is_array($entry['rolesRequired'] ) ) {
            if(!in_array($currentUserRole,$entry['rolesRequired'])) {
                return false;
            }
        }
        if(is_array($entry['rolesRestricted'])) {
            if(in_array($currentUserRole,$entry['rolesRestricted'])) {
                return false;
            }
        }
        return true;
    }
}