<?php

namespace App\Entity;

final class Product implements CartItem
{

    public function __construct(private string $id, private float $price)
    {
    }

    /**
     * Get the value of price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
