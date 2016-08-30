<?php

namespace Peg\Domain\Events;

interface PictureEventInterface
{
    public function getPictureUrl() : string;
}
