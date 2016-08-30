<?php

namespace Peg\Bundles\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Peg\Domain\ValueObject\Email;

/**
 * Class User.
 *
 *
 * @MongoDB\Document(repositoryClass="\Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\UserRepository")
 */
class User
{
    /**
     * @var string
     *
     * @MongoDB\Id(strategy="UUID")
     */
    private $id;

    /**
     * @var Email
     *
     * @MongoDB\Field(value="email", type="email")
     */
    private $email;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }
}
