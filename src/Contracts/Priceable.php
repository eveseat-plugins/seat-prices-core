<?php

namespace RecursiveTree\Seat\PricesCore\Contracts;

interface Priceable extends HasTypeID
{
    public function getAmount(): int;

    public function setPrice(float $price): void;
}