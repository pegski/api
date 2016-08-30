<?php

namespace Peg\Domain\Commands;

use Peg\Bundles\ApiBundle\Document\PictureEvent;
use Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\PictureEventRepository;
use Peg\Domain\Exception\PegNotFoundException;
use Peg\Repository\PegRepositoryInterface;

final class UpdatePictureHandler extends EventHandler
{
    /**
     * @var PictureEventRepository
     */
    private $eventRepository;

    /**
     * @var PegRepositoryInterface
     */
    private $pegRepository;

    /**
     * @param PegRepositoryInterface $pegRepository
     * @param PictureEventRepository $eventRepository
     */
    public function __construct(PegRepositoryInterface $pegRepository, PictureEventRepository $eventRepository)
    {
        parent::__construct($pegRepository);

        $this->eventRepository = $eventRepository;
    }

    /**
     * Handle the update picture command.
     *
     * @param UpdatePicture $command
     *
     * @throws PegNotFoundException
     */
    public function handle(UpdatePicture $command)
    {
        $event = PictureEvent::create(
            $this->getPegByShortCode($command->getShortCode()),
            $command->getDescription(),
            $command->getPicture(),
            $command->getLocation()
        );

        $this->eventRepository->save($event);
    }
}
