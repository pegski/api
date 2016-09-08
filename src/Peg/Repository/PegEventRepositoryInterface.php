<?php

namespace Peg\Repository;

use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;

interface PegEventRepositoryInterface
{
    /**
     * @param Peg $peg
     *
     * @return Event[]|array
     */
    public function findAllForPeg(Peg $peg) : array;

    public function save(Event $event, $sync = true);
}
