<?php

namespace Peg\Repository;

use Peg\Bundles\ApiBundle\Document\Peg;

/**
 * Peg repository.
 */
interface PegRepositoryInterface
{
    /**
     * Find on peg by a short code.
     *
     * @param string $shortCode
     *
     * @return Peg|null
     */
    public function findOneByShortCode(string $shortCode);

    /**
     * Find the unique short codes used in the Pegs stored in MongoDB.
     *
     * @return mixed[]
     */
    public function findUsedShortCodes();
}
