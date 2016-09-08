<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Resolver;

use forxer\Gravatar\Gravatar;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Repository\PegEventRepositoryInterface;

class PegEventResolver
{
    /**
     * @var PegEventRepositoryInterface
     */
    private $pegEventRepository;

    public function __construct(PegEventRepositoryInterface $pegEventRepository)
    {
        $this->pegEventRepository = $pegEventRepository;
    }

    /**
     * @param Peg $peg
     *
     * @return Event[]
     */
    public function resolveEventsByPeg(Peg $peg): array
    {
        return $this->pegEventRepository->findAllForPeg($peg);
    }

    public function resolveFieldAvatarUrl(Event $event)
    {
        if (!$event->getEmail()) {
            return null;
        }

        return Gravatar::image($event->getEmail());
    }

    public function resolveFieldProfileUrl(Event $event)
    {
        if (!$event->getEmail()) {
            return null;
        }

        return Gravatar::profile($event->getEmail());
    }
}
