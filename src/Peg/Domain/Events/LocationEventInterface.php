<?php

namespace Peg\Domain\Events;

interface LocationEventInterface
{
    public function getLocation() : string;
}
