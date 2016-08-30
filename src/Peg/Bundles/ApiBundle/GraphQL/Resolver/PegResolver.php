<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Resolver;

use Overblog\GraphQLBundle\Error\UserWarning;
use Peg\Bundles\ApiBundle\Document\Peg;
use Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\PegRepository;

class PegResolver
{
    /**
     * @var PegRepository
     */
    private $repository;

    /**
     * PegResolver constructor.
     *
     * @param PegRepository $repository
     */
    public function __construct(PegRepository $repository)
    {
        $this->repository = $repository;
    }

    public function resolvePegs(): array
    {
        return $this->repository->findAll();
    }

    public function resolvePeg(string $shortcode): Peg
    {
        /** @var Peg|null $peg */
        $peg = $this->repository->findOneBy(['shortcode' => $shortcode]);

        if (!$peg) {
            throw new UserWarning("No peg found for shortcode '{$shortcode}'");
        }

        return $peg;
    }
}
