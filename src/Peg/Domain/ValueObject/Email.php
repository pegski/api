<?php

namespace Peg\Domain\ValueObject;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Constraints\EmailValidator;

class Email
{
    /**
     * @var string
     */
    private $value;

    /**
     * Email constructor.
     *
     * @throws EmailInvalidException
     */
    public function __construct(string $value)
    {
        $validator = new EmailValidator(false);

        try {
            $validator->validate($value, new EmailConstraint());
        } catch (UnexpectedTypeException $e) {
            throw new EmailInvalidException("The email '$value' is not valid", 0, $e);
        }

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
