<?php

/*
 *  A DTO that will be held in a DTO collection should implement this interface.
 */

interface DtoInterface
{
    /* getId() should return the main ID associated with the object.  For
    *    example, getId() in the SchoolDto would return the schoolID.  The
    *    collection will use this as the key in the associative array for quick lookup
    */
    public function getId();


}