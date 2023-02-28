<?php

namespace App\Services\Match;

/**
 * Class OrderBook
 *
 * @package \App\Services\Match
 */
class OrderBook
{
    public Direction $direction;
    public array $book;

    public function __construct(Direction $direction)
    {
        $this->direction = $direction;
        $this->book = [];
    }

    public function getFirst()
    {
        return array_shift($this->book);
    }
}
