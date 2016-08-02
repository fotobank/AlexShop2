<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 * The MIT License (MIT)
 * Copyright (c) 2016
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 * Framework Component
 */

/**
 * @namespace
 */
namespace lib\Config;

use Symfony\Component\Yaml\Parser;

/**
 * Config
 * @package  Config
 */
class Config implements InterfaceConfig
{
    /**
     * @var array Configuration data
     */
    protected $config;


    /**
     * Load configuration
     * @throws \lib\Config\ConfigException
     */
    public function __construct()
    {
        try {
            $this->config = $this->loadFiles(SYS_DIR . CONFIGS_DEFAULT_PATH);
        } catch (\Exception $e) {
            throw new ConfigException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Load configuration files to array
     *
     * @param string $path
     *
     * @return array
     * @throws \Exception
     */
    protected function loadFiles($path)
    {
        try {
            $config = [];
            if (!is_dir($path)){
                throw new ConfigException('Configuration directory `' . $path . '` not found');
            }
            $iterator_php = new \GlobIterator($path . '/*.php',
                \FilesystemIterator::KEY_AS_FILENAME
                | \FilesystemIterator::CURRENT_AS_PATHNAME
            );

            foreach ($iterator_php as $name => $file){
                $name = substr($name, 0, -4);
                /** @noinspection PhpIncludeInspection */
                $config[$name] = include $file;
            }
            $iterator_yml = new \GlobIterator($path . '/*.yml',
                \FilesystemIterator::KEY_AS_FILENAME
                | \FilesystemIterator::CURRENT_AS_PATHNAME
            );
            $yaml_parser = new Parser();
            foreach ($iterator_yml as $name => $file){
                $name = substr($name, 0, -4);
                $config[$name] = $yaml_parser->parse(file_get_contents($file));
            }

            return $config;
        } catch (\Exception $e) {
            throw new ConfigException($e->getMessage());
        }
    }

    /**
     * Return configuration by key
     * @api
     *
     * @param string|null $key     of config
     * @param string|null $section of config
     *
     * @throws ConfigException
     * @return array|mixed
     */
    public function getData($key = null, $section = null)
    {
        // configuration is missed
        if (null === $this->config){
            throw new ConfigException('System configuration is missing');
        }

        // return all configuration
        if (null === $key){
            return $this->config;
        }

        assert(
            is_string($key) === true,
            'Config::getData($key):  $key "' . $key . '" is not string'
        );
        
        assert(
            array_key_exists($key, $this->config) === true,
            'Config::getData($key):  key "' . $key . '" not found'
        );

        if (null !== $section){
            return $this->config[$key][$section] ?? null;
        } else {
            return $this->config[$key];
        }
        
    }
}