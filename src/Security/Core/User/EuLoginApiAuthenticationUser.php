<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User;

final class EuLoginApiAuthenticationUser implements EuLoginApiAuthenticationUserInterface
{
    private string $identifier;

    /**
     * @var array<mixed>
     */
    private array $payload;

    /**
     * @param array<mixed> $payload
     */
    public function __construct(string $identifier, array $payload = [])
    {
        $this->payload = $payload;
        $this->identifier = $identifier;
    }

    public static function createFromPayload($identifier, array $payload)
    {
        return new self($identifier, $payload);
    }

    public function eraseCredentials(): void {}

    public function get(string $key, $default = null)
    {
        return $this->getStorage()[$key] ?? $default;
    }

    public function getAttribute(string $key, $default = null)
    {
        return $this->getStorage()[$key] ?? $default;
    }

    public function getAttributes(): array
    {
        return $this->getStorage();
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function getRoles(): array
    {
        return ['IS_AUTHENTICATED_FULLY'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->identifier;
    }

    public function getUsername(): string
    {
        return $this->identifier;
    }

    /**
     * Get the storage.
     *
     * @return array<mixed>
     */
    private function getStorage(): array
    {
        return $this->payload;
    }
}
