<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @template-extends UserProviderInterface<EuLoginApiAuthenticationUserInterface>
 */
interface EuLoginApiAuthenticationUserProviderInterface extends UserProviderInterface
{
    public function loadUserByUsernameAndPayload(string $username, array $payload): UserInterface;
}
