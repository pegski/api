<?php

namespace Peg\Domain\Commands;

final class UpdatePicture
{
    /**
     * @var string
     */
    private $shortCode;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var string|null
     */
    private $location;

    /**
     * @param string      $shortCode
     * @param string      $description
     * @param string      $picture
     * @param string|null $location
     */
    public function __construct(string $shortCode, string $description, string $picture, string $location = null)
    {
        $this->shortCode = $shortCode;
        $this->description = $description;
        $this->picture = $picture;
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getShortCode(): string
    {
        return $this->shortCode;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @return null|string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
