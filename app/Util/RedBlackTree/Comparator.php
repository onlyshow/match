<?php

namespace App\Util\RedBlackTree;

interface Comparator
{
    public function compare(mixed $key1, mixed $key2): int;
}
