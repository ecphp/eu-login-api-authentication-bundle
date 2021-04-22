<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use Facile\JoseVerifier\AbstractTokenVerifier;
use Facile\JoseVerifier\AbstractTokenVerifierBuilder;

final class EuLoginApiAccessTokenVerifierBuilder extends AbstractTokenVerifierBuilder
{
    protected function getExpectedAlg(): ?string
    {
        return null;
    }

    protected function getExpectedEnc(): ?string
    {
        return null;
    }

    protected function getExpectedEncAlg(): ?string
    {
        return null;
    }

    protected function getVerifier(string $issuer, string $clientId): AbstractTokenVerifier
    {
        return new EuLoginApiAccessTokenVerifier($issuer, $clientId, $this->buildDecrypter());
    }
}
