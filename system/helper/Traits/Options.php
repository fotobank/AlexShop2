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

/**
 * Options Trait
 *
 * Example of usage
 *     class Foo
 *     {
 *       use \common\Options;
 *
 *       protected $bar = '';
 *       protected $baz = '';
 *
 *       public function setBar($value)
 *       {
 *           $this->bar = $value;
 *       }
 *
 *       public function setBaz($value)
 *       {
 *           $this->baz = $value;
 *       }
 *     }
 *
 *     $Foo = new Foo(['bar'=>123, 'baz'=>456]);
 *
 * @package common
 */
trait Options
{
    /**
     * @var array Options store
     */
    protected $options;

    /**
     * Get option by key
     * @param string $key
     * @param string|null $section
     * @return mixed
     */
    public function getOption($key, $section = null)
    {
        if (isset($this->options[$key])) {
            if (null !== ($section)) {
                return isset($this->options[$key][$section]) ? $this->options[$key][$section] : null;
            } else {
                return $this->options[$key];
            }
        } else {
            return null;
        }
    }

    /**
     * Set option by key over setter
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setOption($key, $value)
    {
        $method = 'set' . $this->normalizeKey($key);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->options[$key] = $value;
        }
    }

    /**
     * Get all options
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Setup, check and init options
     *
     * Requirements
     * - options must be a array
     * - options can be null
     *
     * @param array $options
     * @return self
     */
    public function setOptions($options)
    {
        // store options by default
        $this->options = (array) $options;

        // apply options
        foreach ($this->options as $key => $value) {
            $this->setOption($key, $value);
        }

        // check and initialize options
        $this->initOptions();

        return $this;
    }

    /**
     * Check and initialize options in package
     * @return void
     */
    protected function initOptions()
    {
        return;
    }

    /**
     * Normalize key name
     * @param  string $key
     * @return string
     */
    private function normalizeKey($key)
    {
        $option = str_replace(['_', '-'], ' ', strtolower($key));
        $option = str_replace(' ', '', ucwords($option));
        return $option;
    }
}
