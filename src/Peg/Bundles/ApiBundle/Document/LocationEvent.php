<?php

namespace Peg\Bundles\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class LocationEvent.
 *
 *
 * @MongoDB\Document(repositoryClass="Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\LocationEventRepository")
 */
class LocationEvent extends Event
{
    public static function create(
        Peg $peg,
        string $description,
        string $location,
        string $comment = null,
        string $email = null
    ) : LocationEvent {
        return new self($peg, $description, $location, $comment, $email);
    }
}
