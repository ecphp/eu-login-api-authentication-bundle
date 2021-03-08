<?php

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use Psr\Http\Message\RequestInterface;

interface EuLoginApiCredentialsInterface
{
    public function getCredentials(RequestInterface $request): array;

    public function hasPopToken(RequestInterface $request): bool;
}
