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
use Jose\Easy\Validate;
use Throwable;

final class EuLoginApiAccessTokenVerifier extends AbstractTokenVerifier
{
    public function verify(string $jwt): array
    {
        $jwt = $this->decrypt($jwt);
        /** @var Validate $validator */
        $validator = $this->create($jwt);

        try {
            return $validator->run()->claims->all();
        } catch (Throwable $e) {
            throw $this->processException($e);
        }
    }
}
