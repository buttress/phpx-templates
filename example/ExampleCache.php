<?php

class ExampleCache implements Psr\SimpleCache\CacheInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        $file = '/tmp/phpx-template-cache/' . $key . '.phpx';
        if (!file_exists($file)) {
            return $default;
        }

        $value = json_decode(file_get_contents($file), true, 3, JSON_THROW_ON_ERROR);
        if ($value['exp'] !== null && $value['exp'] <= time()) {
            unlink($file);
            return $default;
        }

        return $value['value'];
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        $exp = null;
        if ($ttl) {
            if ($ttl instanceof DateInterval) {
                $now = new DateTime();
                $now->add($ttl);
                $exp = $now->getTimestamp();
            } else {
                $exp = time() + $ttl;
            }
        }

        $dir = '/tmp/phpx-template-cache/';
        if (!is_dir($dir) && !mkdir($dir) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Count not create "%s".', $dir));
        }

        file_put_contents($dir . $key . '.phpx', json_encode([
            'key' => $key,
            'exp' => $exp,
            'value' => $value,
        ], JSON_THROW_ON_ERROR));
        return true;
    }

    public function delete(string $key): bool
    {
        // TODO: Implement delete() method.
    }

    public function clear(): bool
    {
        // TODO: Implement clear() method.
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        // TODO: Implement getMultiple() method.
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        // TODO: Implement setMultiple() method.
    }

    public function deleteMultiple(iterable $keys): bool
    {
        // TODO: Implement deleteMultiple() method.
    }

    public function has(string $key): bool
    {
        // TODO: Implement has() method.
    }
}
