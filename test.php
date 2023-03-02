<?php


require __DIR__ . '/vendor/autoload.php';

use App\Util\RedBlackTree\Comparator;
use App\Util\RedBlackTree\TreeMap;
use App\Util\RedBlackTree\TreeEntry;

$tree = new TreeMap(new Class implements Comparator {

    public function compare(mixed $key1, mixed $key2): int
    {
        return bccomp($key1, $key2);
    }
});

$arr = [1, 2, 4, 3, 5, 6, 666, 66];

foreach ($arr as $value) {
    $tree->put($value, null);
}

var_dump($key = $tree->getFirstEntry()->getKey());
$tree->remove($key);
var_dump($tree->getFirstEntry()->getKey());

for ($e = $tree->getFirstEntry(); $e != null; $e = TreeEntry::successor($e)) {
    var_dump($e->getKey());
}
