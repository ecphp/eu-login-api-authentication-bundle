.. _configuration:

Configuration
=============

Hereunder an example of configuration for this bundle.

.. code:: yaml

    eu_login_api_authentication:
        client_id: foo
        client_secret: bar
        environment: acceptance

This bundle uses `EU Login`_ to authenticate the incoming requests.

In order to authenticate, you need to be able to create valid tokens through
your frontend application.

Sometimes, the frontend application is not ready and you still need to be able
to authenticate.

Basically, you need to generate and authenticate tokens without relying on
`EU Login`_.

In order to do that, follow the following steps:

1. Edit the content of your application ``services.yaml`` and add:

.. code-block:: yaml

    services:
        EcPhp\EuLoginApiAuthenticationBundle\Service\LocalEuLoginApiCredentials:
            decorates: 'eu_login_api_authentication.service'
            arguments: ['@.inner']

2. This will replace the `EU Login`_ authentication mechanism by another one
   which does not require any connection to `EU Login`_.

   .. warning:: Be extremely careful, do not enable that in production.

3. Read the `official Symfony documentation`_ if you want to enable this only
   for a particular `environment`_.
