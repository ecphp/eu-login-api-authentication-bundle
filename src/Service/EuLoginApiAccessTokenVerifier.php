<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use Facile\JoseVerifier\AbstractTokenVerifier;
use Throwable;

// TODO: Can we replace this class with \Facile\JoseVerifier\JWTVerifier ?
final class EuLoginApiAccessTokenVerifier extends AbstractTokenVerifier
{
    public function verify(string $jwt): array
    {
        $jwt = $this->decrypt($jwt);
        $validator = $this->create($jwt);

        try {
            $claims = $validator->run();
        } catch (Throwable $e) {
            throw $this->processException($e);
        }

        return $claims;
    }
}
