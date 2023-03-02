<?php

namespace App\Util\RedBlackTree;

interface Entry
{
    public function getKey(): mixed;
    public function getValue(): mixed;
    public function setValue(mixed $value): mixed;
}
