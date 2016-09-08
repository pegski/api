<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\PegEventRepository;
use Peg\Repository\PegRepositoryInterface;

final class AddPegEventHandler extends EventHandler
{
    /**
     * @var PegEventRepository
     */
    private $commentEventRepository;

    /**
     * @param PegRepositoryInterface $pegRepository
     * @param PegEventRepository $commentEventRepository
     */
    public function __construct(PegRepositoryInterface $pegRepository, PegEventRepository $commentEventRepository)
    {
        parent::__construct($pegRepository);
        $this->commentEventRepository = $commentEventRepository;
    }

    /**
     * @param AddPegEvent $command
     */
    public function handle(AddPegEvent $command)
    {
        $event = $command->getPegEvent();
        $this->commentEventRepository->save($event);
    }
}
