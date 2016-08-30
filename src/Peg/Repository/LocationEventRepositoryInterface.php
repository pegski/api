<?php

namespace Peg\Repository;

use Peg\Bundles\ApiBundle\Document\LocationEvent;
use Peg\Bundles\ApiBundle\Document\Peg;

interface LocationEventRepositoryInterface
{
    /**
     * @param Peg $peg
     *
     * @return LocationEvent[]|array
     */
    public function findAllForPeg(Peg $peg): array;

    public function save(LocationEvent $event, $sync = true);
}
