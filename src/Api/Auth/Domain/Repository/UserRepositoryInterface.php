<?php

namespace App\Api\Auth\Domain\Repository;

use App\Api\Auth\Domain\Entity\User\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function checkUserExists(string $email): bool;

    public function findOneById(string $id): ?User;

    public function findOneByEmailOrFail(string $email): User;

    public function findOneUserInactiveByIdAndTokenOrFail(string $id, string $token): User;

    public function findOneUserByIdAndResetPasswordTokenOrFail(string $id, string $resetPasswordToken): User;
}