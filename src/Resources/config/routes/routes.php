<?php

declare(strict_types=1);

use EcPhp\EuLoginApiAuthenticationBundle\Controller\User;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes
        ->add('api_gw_authentication_bundle_user', '/user')
        ->controller(User::class);
};
