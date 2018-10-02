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

namespace core\Db\Cache;


/**
 * Interface InterfaceDataBaseCache
 * @package core/Db/Cache
 */
interface InterfaceDataBaseCache
{

    /**
     * @param string $query
     *
     * @return bool|\mysqli_result|string
     */
    public function getQuery($query);

    /**
     * @param $resource
     *
     * @return bool|void
     */
    public function freeResult($resource);

    /**
     * @param $query_id
     *
     * @return array
     * @internal param $resource
     */
    public function &getRow($query_id);

    /**
     * @param $query_id
     *
     * @return array|bool
     */
    public function fetchRow($query_id);
    /**
     * @param int $query_id
     *
     * @return array|bool
     */
    public function &fetch_assoc($query_id = -1);

    /**
     * @param $query_id
     *
     * @return bool|int
     */
    public function numRows($query_id);


    public function __destruct();

}