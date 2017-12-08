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

    public function count() {
        return count($this->items);
    }
    public function add(DtoInterface $dto) {
        $this->items[$dto->getId()] = $dto;
    }
    public function getById($id) {
        return $this->items[$id];
    }
}