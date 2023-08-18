<?php

namespace RecursiveTree\Seat\PricesCore\Contracts;

interface HasTypeID
{
    /**
     * @return int The eve type id of this object
     */
    public function getTypeID(): int;
}