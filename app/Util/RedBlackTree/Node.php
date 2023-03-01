<?php

namespace App\Util\RedBlackTree;

class Node
{
    private mixed $value;

    private Node|null $left_node = null;

    private Node|null $right_node = null;

    private Node|null $parent_node = null;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public static function create(mixed $value): Node
    {
        return new static($value);
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
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * @return Node|null
     */
    public function getLeftNode(): ?Node
    {
        return $this->left_node;
    }

    /**
     * @param Node|null $left_node
     */
    public function setLeftNode(?Node $left_node): void
    {
        $this->left_node = $left_node;
    }

    /**
     * @return Node|null
     */
    public function getRightNode(): ?Node
    {
        return $this->right_node;
    }

    /**
     * @param Node|null $right_node
     */
    public function setRightNode(?Node $right_node): void
    {
        $this->right_node = $right_node;
    }

    /**
     * @return Node|null
     */
    public function getParentNode(): ?Node
    {
        return $this->parent_node;
    }

    /**
     * @param Node|null $parent_node
     */
    public function setParentNode(?Node $parent_node): void
    {
        $this->parent_node = $parent_node;
    }
}
