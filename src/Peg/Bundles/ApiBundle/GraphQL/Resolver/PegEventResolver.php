<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Resolver;

use forxer\Gravatar\Gravatar;
use Overblog\GraphQLBundle\Definition\Argument;
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
     * @param Peg      $peg
     * @param Argument $args
     *
     * @return Event[]
     */
    public function resolveEventsByPeg(Peg $peg, Argument $args): array
    {
        return $this->pegEventRepository->findAllForPeg($peg, $args['order'] ?? -1, $args['type']);
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
