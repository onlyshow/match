<?php

namespace App\Util\RedBlackTree;

use http\Message;

class TreeEntry implements Entry
{
    private mixed $key;
    private mixed $value;
    private bool $color;

    private TreeEntry|null $left = null;
    private TreeEntry|null $right = null;
    private TreeEntry|null $parent = null;

    public function __construct(mixed $key, mixed $value, TreeEntry|null $parent)
    {
        $this->key = $key;
        $this->value = $value;
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getKey(): mixed
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey(mixed $key): void
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function setValue(mixed $value): mixed
    {
        $oldValue = $this->value;
        $this->value = $value;
        return $oldValue;
    }

    /**
     * @return TreeEntry|null
     */
    public function getLeft(): ?TreeEntry
    {
        return $this->left;
    }

    /**
     * @param TreeEntry|null $left
     */
    public function setLeft(?TreeEntry $left): void
    {
        $this->left = $left;
    }

    /**
     * @return TreeEntry|null
     */
    public function getRight(): ?TreeEntry
    {
        return $this->right;
    }

    /**
     * @param TreeEntry|null $right
     */
    public function setRight(?TreeEntry $right): void
    {
        $this->right = $right;
    }

    /**
     * @return TreeEntry|null
     */
    public function getParent(): ?TreeEntry
    {
        return $this->parent;
    }

    /**
     * @param TreeEntry|null $parent
     */
    public function setParent(?TreeEntry $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return bool
     */
    public function getColor(): bool
    {
        return $this->color;
    }

    /**
     * @param bool $color
     */
    public function setColor(bool $color): void
    {
        $this->color = $color;
    }

    public static function successor(TreeEntry|null $t): ?TreeEntry
    {
        if (is_null($t)) {
            return null;
        } elseif (!is_null($t->getRight())) {
            $p = $t->getRight();
            while (!is_null($p->getLeft())) {
                $p = $p->getLeft();
            }
            return $p;
        } else {
            $p = $t->parent;
            $ch = $t;
            while (!is_null($p) && $ch === $p->right) {
                $ch = $p;
                $p = $p->getParent();
            }
            return $p;
        }
    }
}
