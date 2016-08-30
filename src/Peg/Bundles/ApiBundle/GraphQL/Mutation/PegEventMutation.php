<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Mutation;

use League\Tactician\CommandBus;
use Overblog\GraphQLBundle\Error\UserWarning;
use Peg\Bundles\ApiBundle\Document\CommentEvent;
use Peg\Bundles\ApiBundle\Document\LocationEvent;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Bundles\ApiBundle\Document\PictureEvent;
use Peg\Domain\Commands\AddComment;
use Peg\Domain\Commands\AddPicture;
use Peg\Domain\Commands\UpdateLocation;

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

    public function createPegLocationEvent(Peg $peg, string $location, string $comment = null, string $email = null) : LocationEvent
    {
        $pegEvent = LocationEvent::create($peg, 'LocationEvent', $location, $comment, $email);
        $command = new UpdateLocation($pegEvent);

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $e) {
            throw new UserWarning($e->getMessage());
        }

        return $pegEvent;
    }

    public function createPegCommentEvent(Peg $peg, string $comment, string $location = null, string $email = null) : CommentEvent
    {
        $pegEvent = CommentEvent::create($peg, 'CommentEvent', $comment, $location, $email);
        $command = new AddComment($pegEvent);

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $e) {
            throw new UserWarning($e->getMessage());
        }

        return $pegEvent;
    }

    public function createPegPhotoEvent(Peg $peg, string $photoUrl, string $comment = null, string $location = null, string $email = null) : PictureEvent
    {
        $pegEvent = PictureEvent::create($peg, 'PhotoEvent', $photoUrl, $location, $comment, $email);
        $command = new AddPicture($pegEvent);

        try {
            $this->commandBus->handle($command);
        } catch (\Exception $e) {
            throw new UserWarning($e->getMessage());
        }

        return $pegEvent;
    }
}
