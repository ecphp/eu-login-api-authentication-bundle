<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use Psr\Http\Message\RequestInterface;

interface EuLoginApiCredentialsInterface
{
    public function getCredentials(RequestInterface $request): array;

    public function hasPopToken(RequestInterface $request): bool;
}
