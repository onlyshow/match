<?php

namespace App\Util\RedBlackTree;

class RedBlackTree
{
    protected Comparator $comparator;

    protected Node|null $root_node;

    protected int $node_count;

    public function __construct(Comparator $comparator)
    {
        $this->comparator = $comparator;
    }

    private function compare(Node $s, Node $o)
    {
        return $this->comparator->compare($s, $o);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function insert(mixed $value): void
    {
        $new_node = Node::create($value);
        if (!$this->root_node) {
            //tree is empty
            $this->root_node = $new_node;
        } else {
            $node = $this->root_node;
            while (true) {
                if (($ret = $this->compare($node, $new_node)) > 0) {
                    if ($node->getLeftNode()) {
                        $node = $node->getLeftNode();
                    } else {
                        $new_node->setParentNode($node);
                        $node->setLeftNode($new_node);
                        break;
                    }
                } elseif ($ret == 0) {
                    throw new \InvalidArgumentException('can not insert the same value');
                } else {
                    if ($node->getRightNode()) {
                        $node = $node->getRightNode();
                    } else {
                        $new_node->setParentNode($node);
                        $node->setRightNode($new_node);
                        break;
                    }
                }
            }
        }
        ++$this->node_count;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function delete(mixed $value): void
    {
        if (!$this->node_count) {
            return;
        }
        $node = $this->root_node;
        $new_node = Node::create($value);
        while (true) {
            if (($ret = $this->compare($node, $new_node)) > 0) {
                if (!$node->getLeftNode()) {
                    return;
                } else {
                    $node = $node->getLeftNode();
                }
            } elseif ($ret == 0) {
                --$this->node_count;
                $parent_node = $node->getParentNode();
                //no children
                if (!$node->getLeftNode() && !$node->getRightNode()) {
                    if (!$parent_node) {
                        //root node deleted
                        $this->root_node = null;
                        return;
                    }
                    //leaf node
                    if ($node === $parent_node->getLeftNode()) {
                        $parent_node->setLeftNode(null);
                    } else {
                        $parent_node->setRightNode(null);
                    }
                    return;
                } elseif (!$node->getLeftNode() || !$node->getRightNode()) {
                    //node has only one child
                    if ($node->getLeftNode()) {
                        if (!$parent_node) {
                            $this->root_node = $node->getLeftNode();
                            $this->root_node->setParentNode(null);
                            return;
                        }
                        //left node exist
                        $node->getLeftNode()->setParentNode($parent_node);
                        if ($node === $parent_node->getLeftNode()) {
                            $parent_node->setLeftNode($node->getLeftNode());
                        } else {
                            $parent_node->setRightNode($node->getLeftNode());
                        }
                        return;
                    } else {
                        if (!$parent_node) {
                            $this->root_node = $node->getRightNode();
                            $this->root_node->setParentNode(null);
                            return;
                        }
                        //right node exist
                        $node->getRightNode()->setParentNode($parent_node);
                        if ($node === $parent_node->getRightNode()) {
                            $parent_node->setRightNode($node->getRightNode());
                        } else {
                            $parent_node->setLeftNode($node->getRightNode());
                        }
                        return;
                    }
                } else {
                    //two children  exist
                    //look for min node of right subtree
                    $t_node = $right_first_node = $node->getRightNode();
                    while (true) {
                        if (!$t_node->getLeftNode()) {
                            $t_node->setLeftNode($node->getLeftNode());
                            if ($parent_node) {
                                if ($node === $parent_node->getLeftNode()) {
                                    $parent_node->setLeftNode($t_node);
                                } else {
                                    $parent_node->setRightNode($t_node);
                                }
                                $t_node->setParentNode($parent_node);
                            } else {
                                $this->root_node = $t_node;
                                $t_node->setParentNode(null);
                            }

                            if ($t_node->getRightNode()) {
                                if ($t_node !== $right_first_node) {
                                    $t_node->getParentNode()->setLeftNode($t_node->getRightNode());
                                    $t_node->getRightNode()->setParentNode($t_node->getParentNode());
                                } else {
                                    //do nothing
                                }
                            } else {
                                //do nothing
                            }

                            if ($t_node !== $right_first_node) {
                                $t_node->setRightNode($right_first_node);
                                $right_first_node->setParentNode($t_node);
                                $right_first_node->setLeftNode(null);
                            } else {
                                //do nothing
                            }
                            return;
                        } else {
                            $t_node = $t_node->getLeftNode();
                        }
                    }
                }
            } else {
                if (!$node->getRightNode()) {
                    return;
                } else {
                    $node = $node->getRightNode();
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getNodeCount(): int
    {
        return $this->node_count;
    }

    /**
     * @param callable $callback
     * @return void
     */
    public function debug(callable $callback): void
    {
        $this->traverseNode($this->root_node, $callback);
    }

    /**
     * @param Node|null $node
     * @param callable $callback
     * @return void
     */
    private function traverseNode(Node|null $node, callable $callback): void
    {
        if ($node != null) {
            $callback($node);
            $this->traverseNode($node->getLeftNode(), $callback);
            $this->traverseNode($node->getRightNode(), $callback);
        }
    }
}
