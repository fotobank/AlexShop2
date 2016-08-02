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

use core\Autoloader;
use proxy\Session;
use Tracy\Debugger;
use Core\Alex;


include(ROOT . 'vendor/autoload.php');
include(SYS_DIR . 'core/Autoloader.php');
new Autoloader();

require SYS_DIR . 'inc/api_functions.php';
require SYS_DIR . 'inc/functions.php';
require SYS_DIR . 'inc/global.php';

Session::start();

if(DEBUG_MODE || Session::get('logged') === true)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
}
else
{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
if(getenv('SITE_LOG') === 'true')
{
    ini_set('log_errors', 1);
}
else
{
    ini_set('log_errors', 0);
}

/*$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();*/

// профилирование при DEBUG_MODE
/*if(DEBUG_MODE && !is_ajax())
{
    Registry::build('Test');
}*/

Alex::checkDir(ROOT.'tmp/log', 0777);

/** PRODUCTION or DEVELOPMENT or DETECT */
Debugger::enable(Debugger::DETECT, ROOT.'tmp/log');
/** выводить нотисы в строке
 * true - вызов Exception
 */
Debugger::$strictMode = false;
Debugger::$email      = 'aleksjurii@mail.com';
Debugger::$maxDepth   = 5; // default: 3
Debugger::$maxLen     = 200; // default: 150
Debugger::$showLocation = true;
Debugger::$errorTemplate = ROOT . 'usr/html/404/404.html';
Debugger::barDump(get_defined_vars());
include(SYS_DIR . 'lib/tracy/src/shortcuts.php');


//dump(ROOT);
//Debugger::barDump($arr, 'The Array');

//Debugger::barDump($_SERVER, 'SERVER');
//Debugger::dump($_SERVER);

//Debugger::fireLog('Hello World'); // render string into Firebug console
//Debugger::fireLog($_SERVER); // or even arrays and objects
//Debugger::fireLog(new Exception('Test Exception')); // or exceptions

//$err = new Error(Config::getInstance());

//throw new exception\CommonException('Err', 301);
// echo $test_test; // Notice
// trigger_error('Это тест' , E_USER_ERROR ); // User_Error
// throw new Exception('this is a test'); // Uncaught Exception
// echo fatal(); // Fatal Error
// $test = new TestClass();

// включаем asserts
if(ini_get('zend.assertions') != -1) {
    ini_set('zend.assertions', DEBUG_MODE);
}
ini_set('assert.active', DEBUG_MODE);
// переключаем на исключения
ini_set('assert.exception', DEBUG_MODE);
// тест
//assert(false, 'Remove it!');

// защита
parse_req($_REQUEST);
$_SERVER['REQUEST_URI'] = filter($_SERVER['REQUEST_URI'], 'reqUri');
$_SERVER['REMOTE_ADDR'] = filter($_SERVER['REMOTE_ADDR'], 'ip');