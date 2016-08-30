<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Mutation;

use League\Tactician\CommandBus;

final class CommentMutation
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * CommandMutation constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function createComment()
    {
    }
}
