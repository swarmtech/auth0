<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Identity;

use Zend\Permissions\Rbac\Role;
use ZF\MvcAuth\Identity\IdentityInterface;

final class Auth0Identity extends Role implements IdentityInterface
{
    const DEFAULT_ROLE = 'default';

    private $id;
    private $fullName;
    private $picture;
    private $locale;
    private $nickname;
    private $firstName;
    private $email;

    /**
     * @param string $id
     * @param string $fullName
     * @param string $picture
     * @param string $locale
     * @param string $nickname
     * @param string $firstName
     * @param string|null $email
     */
    public function __construct(
        string $id,
        string $fullName,
        string $picture,
        string $nickname,
        string $locale = null,
        string $firstName = null,
        string $email = null
    )
    {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->picture = $picture;
        $this->nickname = $nickname;
        $this->locale = $locale;
        $this->firstName = $firstName;
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

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function getLocale():?  string
    {
        return $this->locale;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
