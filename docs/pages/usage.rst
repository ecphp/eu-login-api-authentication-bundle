Usage
=====

Step 1
~~~~~~

Follow the :ref:`installation` procedure.

Step 2
~~~~~~

Configure the configuration files accordingly and the security of your Symfony
application.

Step 3
~~~~~~

Get a valid token from your front-end application.

Step 4
~~~~~~

- Make a request to ``/api/user`` with the ``Authorization`` header.

``curl -X GET "http://127.0.0.1:8000/api/user" -H "Authorization: pop <insert-token-here>"``

Step 5
~~~~~~

Make sure that the development routes are enabled.

If they are not, create a new file ``eu-login-api-authentication-bundle.yaml``
in ``config/packages/routes/dev/`` with the following content:

.. code-block:: yaml

    eu_login_api_authentication_bundle:
        resource: '@EuLoginApiAuthenticationBundle/Resources/config/routes/routes.php'
        prefix: /api

The routes ``/api/token`` and ``/api/user`` will be available.

Generate a basic token:

``GET http://127.0.0.1:8000/api/token``

And the response:

.. code-block::

    HTTP/1.1 200 OK
    Cache-Control: no-cache, private
    Content-Type: application/json
    Date: Thu, 22 Apr 2021 13:31:44 GMT, Thu, 22 Apr 2021 13:31:44 GMT
    Host: 127.0.0.1:8000
    X-Debug-Token: 4ff71a
    X-Debug-Token-Link: http://127.0.0.1:8000/_profiler/4ff71a
    X-Powered-By: PHP/7.4.16
    X-Robots-Tag: noindex
    Content-Length: 288
    Connection: close

    {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUp6ZFdJaU9pSjFjMlZ5WHpZd09ERTNZV013TUdWbFptSWlMQ0poWTNScGRtVWlPblJ5ZFdWOS5DVFRZT1VtcldZaVFPRUUzaUJ0OWhKS1dLRURDQlNUR0twOGxMR3lqNlNJIn0.nEPLVP34eSMge_qz9Jrw88_w6BQHzKKk6aeyj38F8rU"
    }


Generate a basic token with custom fields:

.. code-block::

    POST http://127.0.0.1:8000/api/token
    Content-Type: application/json

    { "key" : "value", "list": [1, 2, 3] }

and the response:

.. code-block::

    HTTP/1.1 200 OK
    Cache-Control: no-cache, private
    Content-Type: application/json
    Date: Thu, 22 Apr 2021 13:32:38 GMT, Thu, 22 Apr 2021 13:32:38 GMT
    Host: 127.0.0.1:8000
    X-Debug-Token: 80b1ca
    X-Debug-Token-Link: http://127.0.0.1:8000/_profiler/80b1ca
    X-Powered-By: PHP/7.4.16
    X-Robots-Tag: noindex
    Content-Length: 340
    Connection: close

    {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUpyWlhraU9pSjJZV3gxWlNJc0lteHBjM1FpT2xzeExESXNNMTBzSW5OMVlpSTZJblZ6WlhKZk5qQTRNVGRoWmpZME5ERXdZeUlzSW1GamRHbDJaU0k2ZEhKMVpYMC5tRmsyZklCVk5vaTJuNV9NZmhYeDVNLTNpNGxGSHMyaEdEbUtCSnV0VzdzIn0.HJY2L-oS09IqVI_q0SGGzarE6l6ZXHQAb14F-1STwzQ"
    }

Use ``/api/user`` to introspect a token:

.. code-block::

    GET http://127.0.0.1:8000/api/user
    Authorization: pop eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUp6ZFdJaU9pSjFjMlZ5WHpZd09ERTNPV1ppWVRVeFpUTWlMQ0poWTNScGRtVWlPblJ5ZFdWOS5QcmlsNFhSdUhDV0lXLTUzZThaLWstUzJwSHpDUXNmci1UN094Y2MwbjQ4In0.8MotNjUqlVgzKnAY4CGDm63TdmGrBsPf3_Jvjy_q3qs

And the response:

.. code-block::

    HTTP/1.1 200 OK
    Cache-Control: no-cache, private
    Content-Type: application/json
    Date: Thu, 22 Apr 2021 13:29:33 GMT, Thu, 22 Apr 2021 13:29:33 GMT
    Host: 127.0.0.1:8000
    X-Debug-Token: 716819
    X-Debug-Token-Link: http://127.0.0.1:8000/_profiler/716819
    X-Powered-By: PHP/7.4.16
    X-Robots-Tag: noindex
    Content-Length: 42
    Connection: close

    {
    "sub": "user_60817a347e064",
    "active": true
    }

Introspect a token having custom fields

.. code-block::

    GET http://127.0.0.1:8000/api/user
    Authorization: pop eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUpyWlhraU9pSjJZV3gxWlNJc0lteHBjM1FpT2xzeExESXNNMTBzSW5OMVlpSTZJblZ6WlhKZk5qQTRNVGRoTldJek1USmlaQ0lzSW1GamRHbDJaU0k2ZEhKMVpYMC4yOVBtYjJSa1NuM0x0MkpWNXNlb0hzWENDRDRPSTl4ZTB2Z2QtMVVmT3JnIn0.10mkjiaaHuO4EdHXAxT6P-Q__f4ztOGgBNPsCIjFdf0

And the response:

.. code-block::

    HTTP/1.1 200 OK
    Cache-Control: no-cache, private
    Content-Type: application/json
    Date: Thu, 22 Apr 2021 13:30:52 GMT, Thu, 22 Apr 2021 13:30:52 GMT
    Host: 127.0.0.1:8000
    X-Debug-Token: 47d353
    X-Debug-Token-Link: http://127.0.0.1:8000/_profiler/47d353
    X-Powered-By: PHP/7.4.16
    X-Robots-Tag: noindex
    Content-Length: 71
    Connection: close

    {
    "key": "value",
    "list": [
        1,
        2,
        3
    ],
    "sub": "user_60817a5b312bd",
    "active": true
    }
