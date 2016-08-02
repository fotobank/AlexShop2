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

use admin\applications\Timer\Profiler\Profiler as Instance;


/**
 * ����������:
 *
 * use proxy\Profiler;
 * Profiler::setIterataions(1000);
 * Profiler::testFunction('rand',[0,999]);
 * Profiler::generateResults();
 *
 * Class Profiler
 * @package Proxy
 *
 * @method   static mixed testFunction($functionName, $arguments = [])
 * @see      proxy\Profiler::profileFunction()
 *
 * @method   static number testClass($className, $arguments = [])
 * @see      proxy\Profiler::profileClass()
 *
 * @method   static number testMethod($object, $methodName, $arguments = [])
 * @see      proxy\Profiler::profileMethod()
 *
 * @method   static array getResults()
 * @see      proxy\Profiler::getResults()
 *
 * @method   static string generateResults()
 * @see      proxy\Profiler::generateResults()
 *
 * @method   static string printResults()
 * @see      proxy\Profiler::printResults()
 *
 * @method   static Profiler setIterataions($iterataions)
 * @see      proxy\Profiler::setIterataions()
 *
 */
class Profiler extends AbstractProxy
{
    /**
     * Init instance
     *
     * @return Instance
     */
    protected static function initInstance()
    {
        $instance = new Instance();
        return $instance;
    }
}