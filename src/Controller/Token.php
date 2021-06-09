<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Controller;

use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class Token
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'token' => JWT::encode(
                    [
                        'at' => JWT::encode(
                            (array) json_decode($request->getContent(), true) +
                            ['sub' => uniqid('user_'), 'active' => true],
                            uniqid()
                        ),
                    ],
                    uniqid()
                ),
            ],
            200
        );
    }
}
