<?php

namespace Peg\Bundles\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Event.
 *
 *
 * @MongoDB\MappedSuperclass
 */
abstract class Event
{
    /**
     * @var string
     *
     * @MongoDB\Id(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $description;

    /**
     * @var string|null
     *
     * @MongoDB\Field(type="string")
     */
    private $location;

    /**
     * @var string|null
     *
     * @MongoDB\Field(type="string")
     */
    private $comment;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $happenedAt;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $email;

    /**
     * @var Peg
     *
     * @MongoDB\ReferenceOne(targetDocument="Peg")
     */
    private $peg;

    protected function __construct(Peg $peg, string $description, string $location = null, string $comment = null, string $email = null)
    {
        $this->peg = $peg;
        $this->description = htmlspecialchars($description);
        $this->location = $location ? htmlspecialchars($location) : null;
        $this->comment = $comment ? htmlspecialchars($comment) : null;
        $this->email = $email ? htmlspecialchars($email) : null;

        $this->happenedAt = (new \DateTime())->format(\DateTime::ATOM);
    }

    public function getType()
    {
        return get_called_class();
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getPeg(): Peg
    {
        return $this->peg;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return mixed
     */
    public function getHappenedAt()
    {
        return $this->happenedAt;
    }
}
