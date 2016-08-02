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

/**
 * @namespace
 */
namespace helper\Traits;
use Exception;


/**
 * Helper trait
 *
 * Dependency Injection
 */
trait Helper
{
    /**
     * Service Container
     * @var array of helpers
     */
    protected $helpers = [];

    /**
     * @var array of helpers paths
     */
    protected $helpers_path = [];

    /**
     * @var array of plugins paths
     */
    protected $plugins_path = [];

    /**
     * Add helper path
     * @param string $path
     * @return self
     */
    public function addHelperPath($path)
    {
        $path = rtrim(realpath($path), '/');
        if (false !== $path && !in_array($path, $this->helpers_path, true)) {
            $this->helpers_path[] = $path;
        }

        return $this;
    }

    /**
     * Set helpers path
     * @param string|array $helpersPath
     * @return self
     */
    public function setHelpersPath($helpersPath)
    {
        if (is_array($helpersPath)) {
            foreach ($helpersPath as $path) {
                $this->addHelperPath((string)$path);
            }
        } else {
            $this->addHelperPath((string)$helpersPath);
        }
        return $this;
    }

    /**
     *
     */
    public function runPlugins()
    {
        $arr_path = [];
        foreach($this->plugins_path as $path)
        {
            $arr_path = array_merge( $arr_path, glob($path.'\*.php'));
        }
        foreach($arr_path as $a)
        {
            $plugins_name = lcfirst(basename($a, '.php'));
            $this->$plugins_name();
        }
    }

    /**
     * Add plugins path
     * @param string $path
     * @return self
     */
    public function addPluginsPath($path)
    {
        if (false !== $path && !in_array($path, $this->plugins_path, true)) {
            $this->plugins_path[] = $path;
        }
        $this->addHelperPath($path);
        return $this;
    }

    /**
     * Set plugins path
     * @param string|array $plugins_path
     * @return self
     */
    public function setPluginsPath($plugins_path)
    {
        if (is_array($plugins_path)) {
            foreach ($plugins_path as $path) {
                $this->addPluginsPath((string)$path);
            }
        } else {
            $this->addPluginsPath((string)$plugins_path);
        }
        return $this;
    }

    /**
     * Call magic helper
     * @param string $method
     * @param array $args
     * @throws Exception
     * @return mixed
     */
    public function __call($method, $args)
    {
        // Setup key
        $key = static::class .':'. $method;

        // Call callable helper structure (function or class)
        if (array_key_exists($key, $this->helpers) && is_callable($this->helpers[$key])) {
            return call_user_func($this->helpers[$key], $args);
        }

        // Try to find helper file
        foreach ($this->helpers_path as $helperPath) {
            /** @noinspection DisconnectedForeachInstructionInspection */
            $helperPath .= DS . ucfirst($method) . '.php';
            if (is_file($helperPath))
            {
                /** @noinspection PhpIncludeInspection */
                $helperInclude = include $helperPath;
                assert('is_callable($helperInclude)', 'in class "'.__CLASS__.
                                                     '" not found helper method "'.$method.
                                                     '", error in file "'.$helperPath.'"');
                $this->helpers[$key] = $helperInclude;
                return call_user_func($this->helpers[$key], $args);
            }
        }
        throw new Exception('Helper method "'. $method .'" not found for class "' . __CLASS__ . '"');
    }

    /**
     * Normalize key name
     * @param  string $key
     * @return string
     */
    public function ucwordsKey($key)
    {
        $option = str_replace(['_', '-'], ' ', strtolower($key));
        $option = str_replace(' ', '', ucwords($option));
        return $option;
    }
}
