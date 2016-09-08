<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Document\Event;

final class AddPegEvent
{
    private $pegEvent;

    public function __construct(Event $pegEvent)
    {
        $this->pegEvent = $pegEvent;
    }

    public function getPegEvent(): Event
    {
        return $this->pegEvent;
    }
}
