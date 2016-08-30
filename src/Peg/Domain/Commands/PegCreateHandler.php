<?php

namespace Peg\Domain\Commands;

use Doctrine\ODM\MongoDB\DocumentManager;
use Peg\Bundles\ApiBundle\Document\Peg;

class PegCreateHandler
{
    private $documentManager;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    public function handle(PegCreate $pegCreate)
    {
        $peg = $pegCreate->getPeg();

        $this->documentManager->persist($peg);
        $this->documentManager->flush();

        // @todo Implement event listener in order to have the Peg as return
    }
}
