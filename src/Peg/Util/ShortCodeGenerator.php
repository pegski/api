<?php

namespace Peg\Util;

use MikeFrancis\Tokenizr\Tokenizr;
use Peg\Repository\PegRepositoryInterface;

/**
 * Generate unique short codes for the Peg document.
 */
final class ShortCodeGenerator
{
    /**
     * @var Tokenizr
     */
    private $tokenizer;

    /**
     * @param PegRepositoryInterface $pegRepository
     */
    public function __construct(PegRepositoryInterface $pegRepository)
    {
        // Initialize a new tokenizr class.
        $this->tokenizer = new Tokenizr();
        // Set the characters to only lowercase and numbers
        $this->tokenizer->setCharacters('abcdefghkjmnpqrstuvwxyz123456789');
        // Set the amount of characters used for generating a new token code to 5
        $this->tokenizer->setTokenLength(5);
        // Set the already taken short codes
        $this->tokenizer->setExistingTokens($pegRepository->findUsedShortCodes());
    }

    /**
     * Generate a new unique short code of 5 characters.
     *
     * @return string
     */
    public function generateUniqueShortCode()
    {
        return $this->tokenizer->generate();
    }
}
