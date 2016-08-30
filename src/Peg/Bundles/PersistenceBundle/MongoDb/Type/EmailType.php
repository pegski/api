<?php

namespace Peg\Bundles\PersistenceBundle\MongoDb\Type;

use Doctrine\ODM\MongoDB\Types\Type;
use Peg\Domain\ValueObject\Email;

class EmailType extends Type
{
    const NAME = 'email';

    public function convertToDatabaseValue($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (!$value instanceof Email) {
            throw new \InvalidArgumentException('$value must be an email address');
        }

        return (string) $value;
    }

    public function convertToPHPValue($value)
    {
        if (is_null($value)) {
            return null;
        }

        return new Email($value);
    }

    public function closureToPHP()
    {
        return '$return = new \Peg\Domain\ValueObject\Email($value);';
    }
}
