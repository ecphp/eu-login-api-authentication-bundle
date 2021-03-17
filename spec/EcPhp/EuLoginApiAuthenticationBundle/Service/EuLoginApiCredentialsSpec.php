<?php

declare(strict_types=1);

namespace spec\EcPhp\EuLoginApiAuthenticationBundle\Service;

use EcPhp\EuLoginApiAuthenticationBundle\Exception\EuLoginApiAuthenticationException;
use EcPhp\EuLoginApiAuthenticationBundle\Service\EuLoginApiCredentials;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class EuLoginApiCredentialsSpec extends ObjectBehavior
{
    public function disabled_it_can_get_credentials_from_a_request(RequestInterface $request, ClientInterface $httpClient)
    {
        $configuration = [
            'client_id' => 'client_id',
            'client_secret' => 'client_secret',
            'environment' => 'acceptance',
        ];

        $this->beConstructedWith($httpClient, $configuration);

        $token = 'eyJhbGciOiAiRVMyNTYiLCAiY3R5IjoiSldUIn0.eyJhdCI6IkFULTg0MDExNTgtNENWenBjVUJ6TXBzNldISk9jUVNvc29ndThGT3dIQk8wcUV2WjVhb0tVN0VQMXk0eThLVEVscThKdHp5ZG9yRU16SUltTEJ4MnkwVEI1UEh3Z1kwVXhDLXJhOGduQ0YxbFdhbGw3WVQyR0VCQUstUEZVd3NOZ3c0aFFaMWhBa1N4UTdmMlBING1WWk9jQnN6elZxc1cyOENkYkkySTZ5TEM5S3B3dHJwZkh6THBFeFNZaFhrenFmempDSmlramFQNklKN3BTIiwidHMiOjE2MTU5ODAyOTA1MzF9.opB_4uxzgOxhf9BhwF06To7nVnun_ji85sSHV_D5B6Gg9F15cepGxa8ea5bL6pTg3R8MH7QvYdmX82O-lzGUyw';

        $request
            ->hasHeader('Authorization')
            ->willReturn(true);

        $request
            ->getHeaderLine('Authorization')
            ->willReturn('pop ' . $token);

        $response = new Response(200, [], json_encode(['active' => false]));

        $httpClient
            ->sendRequest(Argument::any())
            ->willReturn($response);

        $this
            ->shouldThrow(
                EuLoginApiAuthenticationException::unableToGetCredentials(
                    EuLoginApiAuthenticationException::invalidOrRevokedToken()
                )
            )
            ->duringGetCredentials($request);
    }

    public function it_can_detect_if_the_Authorization_header_is_valid()
    {
        $request = new Request(
            'POST',
            'http://localhost',
            [
                'Authorization' => 'pop foo bar',
            ]
        );

        $this
            ->shouldThrow(
                EuLoginApiAuthenticationException::unableToGetCredentials(
                    EuLoginApiAuthenticationException::invalidAuthorizationHeader(['foo', 'bar'])
                )
            )
            ->duringGetCredentials($request);
    }

    public function it_can_detect_if_the_Authorization_prefix_is_valid()
    {
        $request = new Request(
            'POST',
            'http://localhost',
            [
                'Authorization' => 'bearer foo',
            ]
        );

        $this
            ->shouldThrow(
                EuLoginApiAuthenticationException::unableToGetCredentials(
                    EuLoginApiAuthenticationException::invalidAuthorizationHeaderPrefix('bearer')
                )
            )
            ->duringGetCredentials($request);
    }

    public function it_can_detect_if_the_request_has_an_Authorization_header()
    {
        $request = new Request(
            'POST',
            'http://localhost',
        );

        $this
            ->shouldThrow(EuLoginApiAuthenticationException::class)
            ->duringGetCredentials($request);
    }

    public function it_can_detect_if_the_token_has_a_valid_structure()
    {
        $request = new Request(
            'POST',
            'http://localhost',
            [
                'Authorization' => 'pop foo.foo.foo.foo',
            ]
        );

        $this
            ->shouldThrow(
                EuLoginApiAuthenticationException::unableToGetCredentials(
                    EuLoginApiAuthenticationException::invalidJWTTokenStructure('foo.foo.foo.foo')
                )
            )
            ->duringGetCredentials($request);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EuLoginApiCredentials::class);
    }

    public function let(ClientInterface $client)
    {
        $configuration = [
            'client_id' => 'client_id',
            'client_secret' => 'client_secret',
            'environment' => 'acceptance',
        ];

        $this->beConstructedWith($client, $configuration);
    }
}
