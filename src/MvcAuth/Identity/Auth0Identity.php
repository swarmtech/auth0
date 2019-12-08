<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Identity;

use Zend\Permissions\Rbac\Role;
use ZF\MvcAuth\Identity\IdentityInterface;

final class Auth0Identity extends Role implements IdentityInterface
{
    const DEFAULT_ROLE = 'default';

    private $id;
    private $firstName;
    private $fullName;
    private $picture;
    private $locale;
    private $email;

    /**
     * @param string $id
     * @param string $firstName
     * @param string $fullName
     * @param string $picture
     * @param string $locale
     * @param string|null $email
     */
    public function __construct(
        string $id,
        string $firstName,
        string $fullName,
        string $picture,
        string $locale,
        string $email = null
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->fullName = $fullName;
        $this->picture = $picture;
        $this->locale = $locale;
        $this->email = $email;

        parent::__construct(self::DEFAULT_ROLE);
    }

    public function getRoleId(): string
    {
        return $this->name;
    }

    public function getAuthenticationIdentity(): string
    {
        return $this->id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
