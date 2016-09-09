<?php

namespace Peg\Repository;

use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;

interface PegEventRepositoryInterface
{
    /**
     * @param Peg  $peg
     * @param int  $order
     * @param null $type
     *
     * @return Event[]
     */
    public function findAllForPeg(Peg $peg, int $order, $type = null) : array;

    public function save(Event $event, $sync = true);
}
