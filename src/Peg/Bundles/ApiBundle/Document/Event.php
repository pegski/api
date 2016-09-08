<?php

namespace Peg\Bundles\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\PegEventRepository")
 */
final class Event
{
    const TYPE_PICTURE = 'PegEventPicture';
    const TYPE_COMMENT = 'PegEventComment';
    const TYPE_LOCATION = 'PegEventLocation';

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

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $pictureUrl;

    /**
     * @var string
     *
     * @MongoDB\Field(type="string")
     */
    private $type;

    private function __construct(Peg $peg, string $description, string $location = null, string $comment = null, string $email = null)
    {
        $this->peg = $peg;
        $this->description = htmlspecialchars($description);
        $this->location = $location ? htmlspecialchars($location) : null;
        $this->comment = $comment ? htmlspecialchars($comment) : null;
        $this->email = $email ? htmlspecialchars($email) : null;

        $this->happenedAt = (new \DateTime())->format(\DateTime::ATOM);
    }

    public static function createPictureEvent(
        Peg $peg,
        string $description,
        string $pictureUrl,
        string $location = null,
        string $comment = null,
        string $email = null
    ) : Event {
        $event = new self($peg, $description, $location, $comment, $email);
        $event->pictureUrl = $pictureUrl;
        $event->type = self::TYPE_PICTURE;

        return $event;
    }

    public static function createCommentEvent(
        Peg $peg,
        string $description,
        string $location = null,
        string $comment = null,
        string $email = null
    ) : Event {
        $event = new self($peg, $description, $location, $comment, $email);
        $event->type = self::TYPE_COMMENT;

        return $event;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPeg(): Peg
    {
        return $this->peg;
    }

    public function getDescription()
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

    public function getHappenedAt()
    {
        return $this->happenedAt;
    }

    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
