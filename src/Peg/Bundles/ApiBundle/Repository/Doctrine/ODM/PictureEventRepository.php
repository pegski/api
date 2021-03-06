<?php

namespace Peg\Bundles\ApiBundle\Repository\Doctrine\ODM;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Bundles\ApiBundle\Document\PictureEvent;
use Peg\Repository\PictureEventRepositoryInterface;

/**
 * PictureEventRepository.
 *
 * This class was generated by the Doctrine ODM. Add your own custom
 * repository methods below.
 */
class PictureEventRepository extends DocumentRepository implements PictureEventRepositoryInterface
{
    /**
     * @param Peg $peg
     *
     * @return PictureEvent[]|array
     */
    public function findAllForPeg(Peg $peg): array
    {
        return $this->findBy(['peg' => $peg]);
    }

    public function save(PictureEvent $event, $sync = true)
    {
        $this->dm->persist($event);

        if ($sync === true) {
            $this->dm->flush($event);
        }
    }
}
