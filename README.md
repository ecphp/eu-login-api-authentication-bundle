[![Latest Stable Version][latest stable version]][packagist]
 [![GitHub stars][github stars]][packagist]
 [![Total Downloads][total downloads]][packagist]
 [![GitHub Workflow Status][github workflow status]][github actions]
 [![Scrutinizer code quality][code quality]][scrutinizer code quality]
 [![Type Coverage][type coverage]][sheperd type coverage]
 [![Code Coverage][code coverage]][scrutinizer code quality]
 [![Read the Docs][badge readthedocs]][http readthedocs]
 [![License][license]][packagist]

# EU Login API Authentication Bundle

A bundle for Symfony 5.

## To enable dev service

Create a `services_dev.yml` containing:

```yaml
services:
    EcPhp\EuLoginApiAuthenticationBundle\Service\LocalEuLoginApiCredentials:
        decorates: 'eu_login_api_authentication.service'
        arguments: ['@.inner']
```

## To enable dev routes

Create a new file `eu-login-api-authentication-bundle.yaml` in
`config/packages/routes/dev/` with the following content:

```yaml
eu_login_api_authentication_bundle:
    resource: '@EuLoginApiAuthenticationBundle/Resources/config/routes/routes.php'
    prefix: /api
```

The routes `/api/token` and `/api/user` will be available.

Use `/api/token` to generate a token:

### Generate a basic token:

```
GET http://127.0.0.1:8000/api/token
```

And the response:

```
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
```

### Generate a basic token with custom fields:

```
POST http://127.0.0.1:8000/api/token
Content-Type: application/json

{ "key" : "value", "list": [1, 2, 3] }
```

and the response:

```
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
```

Use `/api/user` to introspect a token:

### Introspect a basic token

```
GET http://127.0.0.1:8000/api/user
Authorization: pop eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUp6ZFdJaU9pSjFjMlZ5WHpZd09ERTNPV1ppWVRVeFpUTWlMQ0poWTNScGRtVWlPblJ5ZFdWOS5QcmlsNFhSdUhDV0lXLTUzZThaLWstUzJwSHpDUXNmci1UN094Y2MwbjQ4In0.8MotNjUqlVgzKnAY4CGDm63TdmGrBsPf3_Jvjy_q3qs
```

And the response:

```
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
```

### Introspect a token with custom fields

```
GET http://127.0.0.1:8000/api/user
Authorization: pop eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdCI6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUpyWlhraU9pSjJZV3gxWlNJc0lteHBjM1FpT2xzeExESXNNMTBzSW5OMVlpSTZJblZ6WlhKZk5qQTRNVGRoTldJek1USmlaQ0lzSW1GamRHbDJaU0k2ZEhKMVpYMC4yOVBtYjJSa1NuM0x0MkpWNXNlb0hzWENDRDRPSTl4ZTB2Z2QtMVVmT3JnIn0.10mkjiaaHuO4EdHXAxT6P-Q__f4ztOGgBNPsCIjFdf0
```

And the response:

```
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
```

Read more on the [dedicated documentation site][http readthedocs].

[packagist]: https://packagist.org/packages/ecphp/eu-login-api-authentication-bundle
[latest stable version]: https://img.shields.io/packagist/v/ecphp/eu-login-api-authentication-bundle.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/ecphp/eu-login-api-authentication-bundle.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/ecphp/eu-login-api-authentication-bundle.svg?style=flat-square
[github workflow status]: https://img.shields.io/github/workflow/status/ecphp/eu-login-api-authentication-bundle/Continuous%20Integration?style=flat-square
[code quality]: https://img.shields.io/scrutinizer/quality/g/ecphp/eu-login-api-authentication-bundle/master.svg?style=flat-square
[scrutinizer code quality]: https://scrutinizer-ci.com/g/ecphp/eu-login-api-authentication-bundle/?branch=master
[type coverage]: https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Fecphp%2Feu-login-api-authentication-bundle%2Fcoverage
[sheperd type coverage]: https://shepherd.dev/github/ecphp/eu-login-api-authentication-bundle
[code coverage]: https://img.shields.io/scrutinizer/coverage/g/ecphp/eu-login-api-authentication-bundle/master.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/ecphp/eu-login-api-authentication-bundle.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
[github actions]: https://github.com/ecphp/eu-login-api-authentication-bundle/actions
[badge readthedocs]: https://img.shields.io/readthedocs/ecphp-eu-login-api-authentication-bundle?style=flat-square
[http readthedocs]: https://ecphp-eu-login-api-authentication-bundle.readthedocs.io/
