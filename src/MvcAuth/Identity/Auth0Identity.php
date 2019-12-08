<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Identity;

use Swarmtech\Auth0\ValueObject\IDToken;
use Swarmtech\Auth0\ValueObject\UserInfo;
use Zend\Permissions\Rbac\Role;
use ZF\MvcAuth\Identity\IdentityInterface;

final class Auth0Identity extends Role implements IdentityInterface
{
    protected static $identity = 'auth0';

    /**
     * @var
     */
    private $decodedToken;

    /**
     * @param $decodedToken
     */
    public function __construct($decodedToken)
    {
        var_dump($decodedToken); exit;
        $this->decodedToken = $decodedToken;

        parent::__construct(self::$identity);
    }

    public function getRoleId(): string
    {
        return static::$identity;
    }

    public function getAuthenticationIdentity(): string
    {
        return $this->decodedToken->subject;
    }
}
