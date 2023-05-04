<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Controller;

use EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User\EuLoginApiAuthenticationUserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

final class User
{
    public function __invoke(Security $security): JsonResponse
    {
        $user = $security->getUser();

        if ($user instanceof EuLoginApiAuthenticationUserInterface) {
            return new JsonResponse($user->getAttributes());
        }

        return new JsonResponse([], 404);
    }
}
