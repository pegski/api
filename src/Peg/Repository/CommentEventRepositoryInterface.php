<?php

namespace Peg\Repository;

use Peg\Bundles\ApiBundle\Document\CommentEvent;
use Peg\Bundles\ApiBundle\Document\Peg;

interface CommentEventRepositoryInterface
{
    /**
     * @param Peg $peg
     *
     * @return CommentEvent[]|array
     */
    public function findAllForPeg(Peg $peg) : array;

    public function save(CommentEvent $event, $sync = true);
}
