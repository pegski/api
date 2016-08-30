<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Document\PictureEvent;

final class AddPicture
{
    /**
     * @var PictureEvent
     */
    private $pegEvent;

    public function __construct(PictureEvent $pegEvent)
    {
        $this->pegEvent = $pegEvent;
    }

    public function getPegEvent(): PictureEvent
    {
        return $this->pegEvent;
    }
}
