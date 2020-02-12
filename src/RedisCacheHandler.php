<?php

declare(strict_types=1);

namespace Swarmtech\Auth0;

use Predis\Client;
use Psr\SimpleCache\CacheInterface;

/**
 * Class RedisCacheHandler
 * @package Swarmtech\Auth0
 */
final class RedisCacheHandler implements CacheInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($key, $default = null)
    {
        $data = $this->client->get($key);

        if (!isset($data)) {
            return null;
        }

        return unserialize(base64_decode($data));
    }

    public function set($key, $value, $ttl = null)
    {
        $value = base64_encode(serialize($value));

        $this->client->set($key, $value);
    }

    public function delete($key)
    {
        $this->client->del($key);
    }

    public function clear()
    {
        $this->client->flushAll();
    }

    public function getMultiple($keys, $ttl = null)
    {
        $cacheValues = array_combine($keys, $this->client->mGet($keys));

        foreach ($cacheValues as $key => $value) {
            if ($value === false && !$this->client->exists($key)) {
                continue;
            }

            $ret[$key] = $value;
        }

        return $ret;
    }

    public function setMultiple($data, $ttl = null)
    {
        // No native TTL support for MSET so we use a transaction
        $transaction = $this->client->multi();

        foreach ($data as $key => $val) {
            $transaction->set($key, $val, $ttl);
        }

        $res = $transaction->exec();

        foreach ($res as $key => $value) {
            if ($value === false) {
                return false;
            }
        }

        return true;
    }

    public function deleteMultiple($keys)
    {
        $transaction = $this->client->multi();
        foreach ($keys as $key) {
            $transaction->del($key);
        }
        $transaction->exec();
    }

    public function has($key)
    {
        $this->client->exists($key);
    }
}
