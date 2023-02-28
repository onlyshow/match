<?php

namespace App\Services\Match;

/**
 * Class Order
 *
 * @package \App\Services\Match
 */
class Order
{
    public int $sequenceId;
    public Direction $direction;
    public string $price;
    public string $amount;

    public function __construct(int $sequenceId, Direction $direction, string $price, string $amount)
    {
    }
}
