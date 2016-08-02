<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2016
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace lib\ServiceLocator;

use RuntimeException;

/**
 * Class ServiceLocator
 *
 * Simple service locator class
 */
class ServiceLocator implements ServiceLocatorInterface
{
    /** @var array */
    protected $servicesDefinitions = [];
    /** @var \Closure[]|mixed */
    protected $services = [];

    /**
     * @param string $name
     *
     * @return mixed
     * @throws RuntimeException
     * @throw RuntimeException
     */
    public function get($name)
    {
        if (!is_string($name) || strlen($name) < 1) {
            throw new RuntimeException(
                'The service name is required.'
            );
        }
        if (!$this->has($name)) {
            throw new RuntimeException(
                "The service {$name} has not been registered with the locator."
            );
        }
        $service   = $this->servicesDefinitions[$name]['definition'];
        $isFactory = $this->servicesDefinitions[$name]['isFactory'];
        if (is_object($service) && !is_callable($service)) {
            return $service;
        } elseif (!$isFactory && isset($this->services[$name])) {
            return $this->services[$name];
        } elseif (is_callable($service)) {
            $createdService = call_user_func_array($service, [$this]);
            if ($isFactory) {
                return $createdService;
            } else {
                $this->services[$name] = $createdService;
                return $this->services[$name];
            }
        }
        throw new RuntimeException(
            "The service {$name} has not been registered correctly."
        );
    }

    /**
     * @param string         $name
     * @param \Closure|mixed $service
     * @param bool           $isFactory
     *
     * @return $this
     * @throws RuntimeException
     * @throw RuntimeException
     */
    public function set($name, $service, $isFactory = false)
    {
        if (!is_string($name) || strlen($name) < 1) {
            throw new RuntimeException(
                'The service name is required.'
            );
        }
        if (isset($this->servicesDefinitions[$name])) {
            $this->remove($name);
        }
        if (
            !is_object($service)
            && !is_callable($service)
        ) {
            $type = gettype($service);
            throw new RuntimeException(
                "Only objects and callable can be registered with the locator but '{$name}' has type '{$type}'."
            );
        }
        if (!is_bool($isFactory)) {
            $type = gettype($isFactory);
            throw new RuntimeException(
                "IsFactory parameter must be a boolean but '{$name}' has type '{$type}'."
            );
        }
        $this->servicesDefinitions[$name] = [
            'definition' => $service,
            'isFactory'  => $isFactory,
        ];
        return $this;
    }
    /**
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return is_string($name)
        && strlen($name) > 1
        && isset($name, $this->servicesDefinitions)
        && isset($this->servicesDefinitions[$name]['definition'])
        && isset($this->servicesDefinitions[$name]['isFactory']);
    }
    /**
     * @param string $name
     *
     * @return $this
     */
    public function remove($name)
    {
        if ($this->has($name)) {
            unset($this->servicesDefinitions[$name]);
            if (isset($this->services[$name])) {
                unset($this->services[$name]);
            }
        }
        return $this;
    }
    /**
     * @return $this
     */
    public function clear()
    {
        $this->services            = [];
        $this->servicesDefinitions = [];
        return $this;
    }
}