<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Mutation;

use League\Tactician\CommandBus;
use Peg\Bundles\ApiBundle\Document\Event;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Domain\Commands\AddPegEvent;
use Peg\Domain\Commands\PegCreate;
use Peg\Util\ShortCodeGenerator;

class PegMutation
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var ShortCodeGenerator
     */
    private $shortCodeGenerator;

    public function __construct(CommandBus $commandBus, ShortCodeGenerator $shortCodeGenerator)
    {
        $this->commandBus = $commandBus;
        $this->shortCodeGenerator = $shortCodeGenerator;
    }

    public function createPeg()
    {
        $peg = Peg::register($this->shortCodeGenerator->generateUniqueShortCode());
        $this->commandBus->handle(new PegCreate($peg));

        $pegEventBorn = Event::createCommentEvent($peg, 'PegCreated', 'A Peg has been born! Give it a nice lifetime');
        $this->commandBus->handle(new AddPegEvent($pegEventBorn));

        return $peg;
    }
}
