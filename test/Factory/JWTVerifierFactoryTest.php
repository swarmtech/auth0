<?php
namespace SwarmtechTest\Auth0\Factory;

use PHPUnit\Framework\TestCase;
use Swarmtech\Auth0\Factory\JWTVerifierFactory;

class JWTVerifierFactoryTest extends TestCase
{
    public function testGetValidAudiencesCase1()
    {
        $instance = new JWTVerifierFactory();
        $reflection = new \ReflectionClass(get_class($instance));
        $method = $reflection->getMethod('getValidAudiences');
        $method->setAccessible(true);

        $auth0Config = [
            'client_id' => 'aaa',
            'valid_audiences' => 'bbb'
        ];

        $result =  $method->invokeArgs($instance, [$auth0Config]);

        self::assertContains('aaa', $result);
        self::assertContains('bbb', $result);
    }

    public function testGetValidAudiencesCase2()
    {
        $instance = new JWTVerifierFactory();
        $reflection = new \ReflectionClass(get_class($instance));
        $method = $reflection->getMethod('getValidAudiences');
        $method->setAccessible(true);

        $auth0Config = [
            'client_id' => 'aaa',
            'valid_audiences' => 'aaa'
        ];

        $result =  $method->invokeArgs($instance, [$auth0Config]);

        self::assertContains('aaa', $result);
        self::assertCount(1, $result);
    }
}
