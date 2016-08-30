<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Document\LocationEvent;

final class UpdateLocation
{
    /**
     * @var LocationEvent
     */
    private $pegEvent;

    public function __construct(LocationEvent $pegEvent)
    {
        $this->pegEvent = $pegEvent;
    }

    public function getPegEvent(): LocationEvent
    {
        return $this->pegEvent;
    }
}
