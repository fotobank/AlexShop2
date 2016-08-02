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

require __DIR__ . '/../src/tracy.php';

use Tracy\Debugger;

$arr = array(10, 20, array('key1' => 'val1', 'key2' => TRUE));

// will show in FireLogger
Debugger::fireLog('Hello World');
Debugger::fireLog($arr);


function first($arg1, $arg2)
{
	second(TRUE, FALSE);
}

function second($arg1, $arg2)
{
	third(array(1, 2, 3));
}

function third($arg1)
{
	throw new Exception('The my exception', 123);
}

try {
	first(10, 'any string');
} catch (Exception $e) {
	Debugger::fireLog($e);
}

?>
<!DOCTYPE html><link rel="stylesheet" href="assets/style.css">

<h1>Tracy: FireLogger demo</h1>

<p>How to <a href="https://tracy.nette.org/#toc-firelogger">enable FireLogger</a>?</p>
