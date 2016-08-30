<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Document\CommentEvent;

final class AddComment
{
    /**
     * @var CommentEvent
     */
    private $pegEvent;

    public function __construct(CommentEvent $pegEvent)
    {
        $this->pegEvent = $pegEvent;
    }

    public function getPegEvent(): CommentEvent
    {
        return $this->pegEvent;
    }
}
