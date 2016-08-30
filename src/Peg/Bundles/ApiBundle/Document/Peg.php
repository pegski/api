<?php

namespace Peg\Bundles\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Peg.
 *
 *
 * @MongoDB\Document(repositoryClass="Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\PegRepository")
 */
class Peg
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
    private $shortcode;

    protected function __construct(string $shortCode)
    {
        $this->shortcode = $shortCode;
    }

    public static function register(string $shortCode) : Peg
    {
        return new self($shortCode);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getShortcode(): string
    {
        return $this->shortcode;
    }
}
