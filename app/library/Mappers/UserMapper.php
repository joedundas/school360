<?php

class UserMapper
{

    public function mapQueryResultsToDTO($mapping_to_userId,$queryResults,$dto) {
        $dto->setUserId($mapping_to_userId);
        for($i=0; $i<count($queryResults); $i++) {
            $queryResult = $queryResults[$i];
            $userId = $queryResult['userId'];
            if($userId != $mapping_to_userId) {
                throw new Exception('Mapping of Query Result to DTO where query result userID does not equal the DTO user ID');
            }
            if($i==0) {
                $this->setCommonDemographicsFromQueryToDTO($queryResult,$dto);
            }
            $dto->addRole($queryResult);
        }
    }

    public function setCommonDemographicsFromQueryToDTO($queryResult,$dto) {
        $dto->setNamePrefix($queryResult['namePrefix']);
        $dto->setFirstName($queryResult['firstName']);
        $dto->setLastName($queryResult['lastName']);
        $dto->setNameSuffix($queryResult['nameSuffix']);
        $dto->setPrimaryEmail($queryResult['email']);
    }




}