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

namespace proxy;

use lib\File\Log as Instance;


/**
 * Class Log
 *
 * @package proxy
 *
 * @method   static putLog($filepath, $contents)
 * @see      lib\File\Log::putLog()
 *
 * @method   static putEmail()
 * @see      lib\File\Log::putEmail()
 *
 * @method   static getFileLog()
 * @see      lib\File\Log::getFileLog()
 *
 * @method   static writeLog()
 * @see      lib\File\Log::writeLog()
 *
 * @method   static write($entry)
 * @see      lib\File\Log::write()
 *
 * @method   static getLog($logFilename)
 * @see      lib\File\Log::getLog()
 *
 * @method   static load()
 * @see      lib\File\Log::load()
 *
 * @method   static emptyLog()
 * @see      lib\File\Log::emptyLog()
 *
 * @method   static setEmail($email)
 * @see      lib\File\Log::setEmail()
 *
 * @method   static setMaxDir($max_dir)
 * @see      lib\File\Log::setMaxDir()
 *
 * @method   static setInterval($interval)
 * @see      lib\File\Log::setInterval()
 *
 * @method   static setMaxFileSize($max_file_size)
 * @see      lib\File\Log::setMaxFileSize()
 *
 * @method   static isExists()
 * @see      lib\File\Log::isExists()
 *
 * @method   static setGlue($glue)
 * @see      lib\File\Log::setGlue()
 *
 */
class Log  extends AbstractProxy
{

    /**
     * Init instance
     *
     * @return Instance
     */
    protected static function initInstance()
    {
        $instance = new Instance();
        $options = Config::getData('log');
        $instance->setOptions($options);
        return $instance;
    }

}