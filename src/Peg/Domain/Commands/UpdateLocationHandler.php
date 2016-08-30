<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\LocationEventRepository;
use Peg\Repository\PegRepositoryInterface;

final class UpdateLocationHandler extends EventHandler
{
    /**
     * @var LocationEventRepository
     */
    private $eventRepository;

    /**
     * @param PegRepositoryInterface  $pegRepository
     * @param LocationEventRepository $eventRepository
     */
    public function __construct(PegRepositoryInterface $pegRepository, LocationEventRepository $eventRepository)
    {
        parent::__construct($pegRepository);
        $this->eventRepository = $eventRepository;
    }

    /**
     * Handle the update location command.
     *
     * @param UpdateLocation $command
     */
    public function handle(UpdateLocation $command)
    {
        $event = $command->getPegEvent();
        $this->eventRepository->save($event);
    }
}
