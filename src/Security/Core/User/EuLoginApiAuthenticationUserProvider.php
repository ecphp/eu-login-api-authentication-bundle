<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User;

use DomainException;
use Override;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

final class EuLoginApiAuthenticationUserProvider implements EuLoginApiAuthenticationUserProviderInterface
{
    #[Override]
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        throw new UserNotFoundException('This user provider does not support this method.');
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        throw new DomainException('Unsupported method call.');
    }

    #[Override]
    public function loadUserByUsernameAndPayload(string $username, array $payload): UserInterface
    {
        return new EuLoginApiAuthenticationUser($username, $payload);
    }

    #[Override]
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    #[Override]
    public function supportsClass(string $class): bool
    {
        return EuLoginApiAuthenticationUser::class === $class;
    }
}
