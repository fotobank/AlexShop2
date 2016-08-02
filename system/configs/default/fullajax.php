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
 * @name  Alex_CMS
 *
 *
 *
 *
 *
 */

if (!defined('ACCESS')) {
    header('Location: /');
    exit;
}


return [
    'loader' => 'empt',
    'loaderStatic' => '0',
    'replace' => ':',
    'blockLinks' => 'get_photo,feed/,ajax,download',
    'storage' => '0',
    'freeCode' => 'SRAX.Effect.add({id:&#039,fullAjax&#039,, start: function(id, request){
                   var opacity = new Fax.opacity(&#039,fullAjax&#039,,1,0.3,10,10),
                   opacity.afterEnd = request,
                   },
                   end: function(id){
                    new Fax.opacity(&#039,fullAjax&#039,,0.3,1,10,10),
                   }
                   })'
];