<?php

namespace App\Util\RedBlackTree;

class TreeMap
{
    private Comparator $comparator;

    private TreeEntry|null $root = null;

    private int $size;

    private int $modCount;

    public function __construct(Comparator $comparator)
    {
        $this->comparator = $comparator;
        $this->size = 0;
        $this->modCount = 0;
    }

    private function compare($key1, $key2): int
    {
        return $this->comparator->compare($key1, $key2);
    }

    public function put(mixed $key, mixed $value)
    {
        $t = $this->root;
        if (is_null($t)) {
            $this->root = new TreeEntry($key, $value, null);
            $this->size = 1;
            $this->modCount += 1;
            return null;
        }

        do {
            $parent = $t;
            $cmp = $this->compare($key, $t->getKey());
            if ($cmp < 0) {
                $t = $t->getLeft();
            } elseif ($cmp > 0) {
                $t = $t->getRight();
            } else {
                return $t->setValue($value);
            }
        } while(!is_null($t));

        $e = new TreeEntry($key, $value, $parent);
        if ($cmp < 0) {
            $parent->setLeft($e);
        } else {
            $parent->setRight($e);
        }

        $this->size += 1;
        $this->modCount += 1;
        return null;
    }

    public function get($key): mixed
    {
        $p = $this->getEntry($key);
        return is_null($p) ? null : $p->getValue();
    }

    public function remove(mixed $key) {
        $p = $this->getEntry($key);
        if (is_null($p)) {return null;}
        $oldValue = $p->getValue();
        $this->deleteEntry($p);
        return $oldValue;
    }

    public function getEntry(mixed $key): ?TreeEntry
    {
        $p = $this->root;
        while ($p != null) {
            $cmp = $this->compare($key, $p->getKey());
            if ($cmp < 0) {
                $p = $p->getLeft();
            } else if ($cmp > 0) {
                $p = $p->getRight();
            } else {
                return $p;
            }
        }
        return null;
    }

    public function getFirstEntry(): ?TreeEntry
    {
        $p = $this->root;
        if (!is_null($p)) {
            while (!is_null($p->getLeft())) {
                $p = $p->getLeft();
            }
        }
        return $p;
    }

    public function deleteEntry(TreeEntry $p): void
    {
        $this->modCount += 1;
        $this->size -= 1;
        // If strictly internal, copy successor's element to p and then make p
        // point to successor.
        if (!is_null($p->getLeft()) && !is_null($p->getRight())) {
            $s = TreeEntry::successor($p);
            $p->setKey($s->getKey());
            $p->setValue($s->getValue());
            $p = $s;
        } // p has 2 children
        // Start fixup at replacement node, if it exists.
        $replacement = (!is_null($p->getLeft()) ? $p->getLeft() : $p->getRight());
        if (!is_null($replacement)) {
            // Link replacement to parent
            $replacement->setParent($p->getParent());
            if (is_null($p->getParent()))
                $this->root = $replacement;
            else if ($p === $p->getParent()->getLeft())
                $p->getParent()->setLeft($replacement);
            else
                $p->getParent()->setRight($replacement);

            // Null out links so they are OK to use by fixAfterDeletion.
            $p->setLeft(null);
            $p->setRight(null);
            $p->setParent(null);
        } else if (is_null($p->getParent())) { // return if we are the only node.
            $this->root = null;
        } else { //  No children. Use self as phantom replacement and unlink.
            if (!is_null($p->getParent())) {
                if ($p === $p->getParent()->getLeft()) {
                    $p->getParent()->setLeft(null);
                } elseif ($p === $p->getParent()->getRight()) {
                    $p->getParent()->setRight(null);
                }
                $p->setParent(null);
            }
        }
    }
}
