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

namespace helper\Post;

use helper\ArrayHelper\ArrayHelper;


/**
 * Class Server
 */
class Post extends ArrayHelper
{
    /**
     * конструктор
     */
    public function __construct()
    {
        if(null !== $_POST)
        {
            $this->properties = &$_POST;
        }

    }

    /**
     * @param                              $post_key
     * @param boolean|float|integer|string $type
     *
     * @return array|bool|float|boolean
     * @internal param $post_data
     * @internal param $path
     */
    public function filter($post_key = null, $type = null)
    {
        $val = null;
        if(!empty($post_key) && $this->has($post_key)) {
            $val = parent::get($post_key);
        } elseif(empty($post_key)) {
            $val = file_get_contents('php://input');
        }
        if($val){
            if ($type === 'string'){
                return (string)preg_replace('/[^\p{L}\p{Nd}\d\s_\-\.\%\s]/iu', '', $val);
            }
            if ($type === 'integer'){
                return (int)$val;
            }
            if ($type === 'float'){
                return (float)$val;
            }
            if ($type === 'boolean'){
                return !empty($val);
            }
        }
        return $val;

    }
}
