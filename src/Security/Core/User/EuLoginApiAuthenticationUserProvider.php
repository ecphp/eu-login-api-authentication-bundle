<?php

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User;

use DomainException;
use Symfony\Component\Security\Core\User\UserInterface;

final class EuLoginApiAuthenticationUserProvider implements EuLoginApiAuthenticationUserProviderInterface
{
    public function loadUserByUsername(string $username): UserInterface
    {
        throw new DomainException('Unsupported method call.');
    }

    public function loadUserByUsernameAndPayload(string $username, array $payload): UserInterface
    {
        return new EuLoginApiAuthenticationUser($username, $payload);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        throw new DomainException('Unsupported method call.');
    }

    public function supportsClass(string $class): bool
    {
        return EuLoginApiAuthenticationUser::class === $class;
    }
}
