<?php

namespace Src\Core;

use Closure;
use Swoole\Coroutine;

abstract class Context
{
    protected function get($key = '')
    {
        return $this->getCoroutineContext($key);
    }

    /**
     * set data into coroutine context by key
     *
     * @param string $key key of context
     */
    protected function set($key, $obj)
    {
        $coroutineId = Coroutine::getCid();
        $this->context[$coroutineId][$key] = $obj;
    }

    /**
     * Get data from coroutine context by key
     *
     * @param string $key key of context
     * @return mixed|null
     */
    protected function getCoroutineContext($key)
    {
        $coroutineId = Coroutine::getCid();
        if (!isset($this->context[$coroutineId][$key])) {
            return null;
        }

        $coroutineContext = $this->context[$coroutineId][$key];

        if ($coroutineContext instanceof Closure) {
            return $coroutineContext();
        } else {
            return $coroutineContext;
        }

        return null;
    }

    protected function clearCidContext()
    {
        $coroutineId = Coroutine::getCid();
        if (isset($this->context[$coroutineId])) {
            unset($this->context[$coroutineId]);
        }
    }
}
