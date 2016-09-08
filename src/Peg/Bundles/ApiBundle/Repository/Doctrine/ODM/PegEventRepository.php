<?php

namespace Peg\Bundles\ApiBundle\Repository\Doctrine\ODM;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Repository\PegEventRepositoryInterface;

final class PegEventRepository extends DocumentRepository implements PegEventRepositoryInterface
{
    /**
     * @param Peg $peg
     *
     * @return Event[]
     */
    public function findAllForPeg(Peg $peg): array
    {
        return $this->findBy(['peg' => $peg]);
    }

    public function save(Event $event, $sync = true)
    {
        $this->dm->persist($event);

        if ($sync === true) {
            $this->dm->flush($event);
        }
    }
}
