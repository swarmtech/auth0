<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Identity;

use Swarmtech\Auth0\ValueObject\IDToken;
use Swarmtech\Auth0\ValueObject\UserInfo;
use Zend\Permissions\Rbac\Role;
use ZF\MvcAuth\Identity\IdentityInterface;

final class Auth0Identity extends Role implements IdentityInterface
{
    /**
     * @var
     */
    private $decodedToken;

    /**
     * @param $decodedToken
     * @param $roleName
     */
    public function __construct($decodedToken, $roleName = 'default')
    {
        $this->decodedToken = $decodedToken;
        $this->name = $roleName;

        parent::__construct($roleName);
    }

    public function getRoleId(): string
    {
        return $this->name;
    }

    public function getAuthenticationIdentity(): string
    {
        return $this->decodedToken->subject;
    }
}
