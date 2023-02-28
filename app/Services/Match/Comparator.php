<?php

namespace App\Services\Match;

/**
 * Class Comparator
 *
 * @package \App\Services\Match
 */
class Comparator
{
    private OrderKey $orderKey;

    public function __construct(OrderKey $orderKey)
    {
        $this->orderKey = $orderKey;
    }

    private function getScale(OrderKey $o1, OrderKey $o2)
    {
        [, $decimal1] = explode('.', $o1);
        [, $decimal2] = explode('.', $o2);
        $scale1 = strlen($decimal1);
        $scale2 = strlen($decimal2);
        return max(strlen($scale1), strlen($scale2));
    }

    public function compareSell(OrderKey $o1, OrderKey $o2): int
    {
        $scale = $this->getScale($o1, $o2);
        // 价格低在前:
        $cmp = bccomp($o1->price, $o2->price, $scale);
        // 时间早在前:
        return $cmp == 0 ? bccomp($o1->sequenceId, $o2->sequenceId) : $cmp;
    }

    public function compareBuy(OrderKey $o1, OrderKey $o2): int
    {
        $scale = $this->getScale($o1, $o2);
        // 价格高在前:
        $cmp = bccomp($o2->price, $o1->price, $scale);
        // 时间早在前:
        return $cmp == 0 ? bccomp($o1->sequenceId, $o2->sequenceId) : $cmp;
    }
}
