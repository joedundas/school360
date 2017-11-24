<?php

class UserFactory
{

    static public function createDTO($type) {
        $type = strtolower($type);
        $dtoType = $type . 'DTO';
        if(class_exists($dtoType)) {
            return new $dtoType();
        }
        else {
            throw new Exception("Invalid user type " . $type . ' givent to user DTO factory');
        }
    }

    static public function createRepository($type) {
        $type = strtolower($type);
        $repositoryType = $type . 'Repository';
        if(class_exists($repositoryType)) {
            return new $repositoryType();
        }
        else {
            throw new Exception("Invalid user type " . $type . ' given to user repository factory');
        }
    }

}