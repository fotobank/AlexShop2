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
 * Alex Framework Component
 */

/**
 * @namespace
 */
namespace Common\Container;

/**
 * Implements regular access to container
 *
 * @package  Common
 *
 * @method void doSetContainer($key, $value)
 * @method mixed doGetContainer($key)
 * @method bool doContainsContainer($key)
 * @method void doDeleteContainer($key)
 *
 * @author   Alex Jurii
 * @created  14.10.2014 10:11
 */
trait RegularAccess
{
    /**
     * Set key/value pair
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->doSetContainer($key, $value);
    }

    /**
     * Get value by key
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->doGetContainer($key);
    }

    /**
     * Check contains key in container
     * @param string $key
     * @return bool
     */
    public function contains($key)
    {
        return $this->doContainsContainer($key);
    }

    /**
     * Delete value by key
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        $this->doDeleteContainer($key);
    }
}
