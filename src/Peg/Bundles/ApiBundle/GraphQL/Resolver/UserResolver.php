<?php

namespace Peg\Bundles\ApiBundle\GraphQL\Resolver;

use Overblog\GraphQLBundle\Error\UserWarning;
use Peg\Bundles\ApiBundle\Document\User;
use Peg\Bundles\ApiBundle\Repository\Doctrine\ODM\UserRepository;

class UserResolver
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * PegResolver constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function resolveUsers(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @throws UserWarning if unable to find user with given email
     */
    public function resolveUser(string $email): User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['email' => $email]);

        if (!$user) {
            throw new UserWarning("Unable to find user with email '{$email}");
        }

        return $user;
    }

    /**
     * @throws UserWarning if unable to find user with given email
     */
    public function resolveUserById(string $userId): User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['id' => $userId]);

        if (!$user) {
            throw new UserWarning("Unable to find user with ID '{$userId}");
        }

        return $user;
    }
}
