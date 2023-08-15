<?php

namespace RecursiveTree\Seat\Prices\Contracts;

interface Priceable extends HasTypeID
{
    public function getAmount(): int;

    public function setPrice(float $price): void;
}