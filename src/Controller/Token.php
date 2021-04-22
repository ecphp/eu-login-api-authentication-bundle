<?php

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

final class Token
{
    public function __invoke(): JsonResponse
    {
        $username = uniqid('user_');

        $payload = [
            'iat' => time(),
            'sub' => $username,
            'jti' => uniqid(),
            'iss' => '/api/token',
            'foo' => 'bar',
        ];

        return new JsonResponse(
            [
                'token' => false,
            ]
        );
    }
}
