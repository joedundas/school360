<?php

/**
 * Created by PhpStorm.
 * User: joedundas
 * Date: 12/8/17
 * Time: 1:49 PM
 */
class AbstractDtoCollection
{
    protected $items = array();
    protected $itemToRoleMap = array();
    protected $mappingToRole = false;
    public function count() {
        return count($this->items);
    }
    public function add(DtoInterface $dto) {
        $this->items[$dto->getId()] = $dto;
    }
    public function getById($id) {
        if(!array_key_exists($id,$this->items)) {
            return false;
        }
        return $this->items[$id];
    }

    public function mapToRole($mapId,$roleId) {
        if(!array_key_exists($mapId,$this->itemToRoleMap)) {
            $this->itemToRoleMap[$mapId] = array();
        }
        $this->itemToRoleMap[$mapId][] = $roleId;
        $this->setMappingToRole(true);
    }
    public function reset() {
        $this->items = array();
        $this->itemsToRoleMap = array();
        $this->setMappingToRole(false);
    }

    private function setMappingToRole($bool) {
        $this->mappingToRole = $bool;
    }
}