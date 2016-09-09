<?php

namespace Peg\Bundles\ApiBundle\Repository\Doctrine\ODM;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Repository\PegEventRepositoryInterface;

final class PegEventRepository extends DocumentRepository implements PegEventRepositoryInterface
{
    public function findAllForPeg(Peg $peg, int $order, $type = null): array
    {
        $query = $this->createQueryBuilder()
                ->field('peg')->equals($peg)
                ->sort('happenedAt', $order);

        if ($type) {
            $query->field('type')->equals($type);
        }

        return $query->getQuery()->execute()->toArray();
    }

    public function save(Event $event, $sync = true)
    {
        $this->dm->persist($event);

        if ($sync === true) {
            $this->dm->flush($event);
        }
    }
}
