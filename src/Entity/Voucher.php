<?php

namespace App\Entity;

final class Voucher implements CartItem
{
    public function __construct(private string $id, private float $discount)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }
}
