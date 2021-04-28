.. _installation:

Installation
============

This package has `a Symfony Flex recipe`_ that will install configuration files
for you.

Default configuration files will be copied in the `dev` environment.

Step 1
~~~~~~

The recommended way to install it is with Composer_ :

.. code-block:: bash

    composer require ecphp/eu-login-api-authentication-bundle

This package has a `Symfony recipe`_ that will provides the minimum configuration files.

.. warning:: Be careful, the recipe will enable some routes in your ``dev`` environment only.
   Those routes might be considered as a security issue if they are enabled in the ``production`` environment.
   Those routes are ``/api/token`` and ``/api/user``.
   Find the documentation related to those routes inside the classes themselves.
   To disable them completely, just delete the file ``packages/config/routes/dev/eu_login_api_authentication.yaml``.

Step 2
~~~~~~

Edit the bundle configuration by editing the file ``config/packages/dev/eu_login_api_authentication.yaml``.

.. code-block:: yaml

    eu_login_api_authentication:
        client_id: foo
        client_secret: bar
        environment: acceptance # Available values are: acceptance, production

Step 3
~~~~~~

This is the crucial part of your application's security configuration.

Edit the security settings of your application by edition the file `config/packages/security.yaml`.

.. code-block:: yaml

    security:
        firewalls:
            dev:
                pattern: ^/(_(profiler|wdt)|css|images|js)/
                security: false
            main:
                anonymous: true
                stateless: true
                provider: eu_login_api_authentication
                guard:
                    authenticators:
                        - eu_login_api_authentication.guard

        access_control:
            - { path: ^/token, role: IS_AUTHENTICATED_ANONYMOUSLY }
            - { path: ^/user, role: IS_AUTHENTICATED_FULLY }

Feel free to change these configuration to fits your need. Have a look at
`the Symfony documentation about security and Guard authentication`_.

.. _a Symfony Flex recipe: https://github.com/symfony/recipes-contrib/blob/master/ecphp/eu-login-api-authentication-bundle/1.0/manifest.json
.. _Composer: https://getcomposer.org
.. _the Symfony documentation about security and Guard authentication: https://symfony.com/doc/current/security/guard_authentication.html
.. _Symfony recipe: https://github.com/symfony/recipes-contrib/tree/master/ecphp/eu-login-api-authentication-bundle/1.0
