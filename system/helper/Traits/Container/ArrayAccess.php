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

namespace common\Container;

/**;
 * Container implements ArrayAccess
 * @see ArrayAccess
 *
 * @method void doSetContainer($key, $value)
 * @method mixed doGetContainer($key)
 * @method bool doContainsContainer($key)
 * @method void doDeleteContainer($key)
 *
 *
 */
trait ArrayAccess
{
	/**
	 * Offset to set
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 *
	 * @throws \Exception
	 */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            throw new \Exception('Class `ArrayAccess` support only associative arrays');
        } else {
            $this->doSetContainer($offset, $value);
        }
    }

    /**
     * Offset to retrieve
     * @param mixed $offset
     * @return string
     */
    public function offsetGet($offset)
    {
        return $this->doGetContainer($offset);
    }

    /**
     * Whether a offset exists
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->doContainsContainer($offset);
    }

    /**
     * Offset to unset
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->doDeleteContainer($offset);
    }
}
