<?php

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface EuLoginApiAuthenticationUserProviderInterface extends UserProviderInterface
{
    public function loadUserByUsernameAndPayload(string $username, array $payload): UserInterface;
}
