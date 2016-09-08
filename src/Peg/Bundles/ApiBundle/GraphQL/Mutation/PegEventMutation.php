<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Mutation;

use League\Tactician\CommandBus;
use Overblog\GraphQLBundle\Error\UserWarning;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Domain\Commands\AddPegEvent;

final class PegEventMutation
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createPegCommentEvent(
        Peg $peg,
        string $comment,
        string $location = null,
        string $email = null
    ) : Event {
        $pegEvent = Event::createCommentEvent($peg, '', $comment, $location, $email);
        $command = new AddPegEvent($pegEvent);

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $e) {
            throw new UserWarning($e->getMessage());
        }

        return $pegEvent;
    }

    public function createPegPictureEvent(
        Peg $peg,
        string $photoUrl,
        string $comment = null,
        string $location = null,
        string $email = null
    ) : Event {
        $pegEvent = Event::createPictureEvent($peg, '', $photoUrl, $location, $comment, $email);
        $command = new AddPegEvent($pegEvent);

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $e) {
            throw new UserWarning($e->getMessage());
        }

        return $pegEvent;
    }
}
