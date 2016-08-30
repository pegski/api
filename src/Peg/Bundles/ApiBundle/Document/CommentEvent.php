<?php

namespace Peg\Bundles\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class CommentEvent.
 *
 *
 * @MongoDB\Document(repositoryClass="Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\CommentEventRepository")
 */
class CommentEvent extends Event
{
    /**
     * @var string
     */
    protected $comment;

    public static function create(
        Peg $peg,
        string $description,
        string $comment,
        string $location = null,
        string $email = null
    ) : CommentEvent {
        return new self($peg, $description, $location, $comment, $email);
    }
}
