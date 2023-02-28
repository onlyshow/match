<?php

namespace App\Services\Match;

/**
 * Class OrderKey
 *
 * @package \App\Services\Match
 */
class OrderKey
{
    public int $sequenceId;
    public string $price;

    public function __construct(int $sequenceId, string $price)
    {
        $this->sequenceId = $sequenceId;
        $this->price = $price;
    }
}
