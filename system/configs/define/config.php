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

version_compare(phpversion(), '7.0.4', '>=') === true or die ('PHP 7.0.4 is required, you have ' . phpversion());

defined('DEBUG_MODE') or define('DEBUG_MODE', true);
// use for production mode 'production' or for developer 'developer'
defined('APP_MODE') or define('APP_MODE', DEBUG_MODE ? 'developer' : 'production');

defined('DEBUG_LOG') or define('DEBUG_LOG', true);

defined('PATH_SEPARATOR') or define('PATH_SEPARATOR', getenv('COMSPEC') ? ';' : ':');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('SALT') or define('SALT', 'qE3!nT^(gj)+?|6~d&.ru|');
// настройки для class Recursive
defined('SCAN_DIR_NAME') or define('SCAN_DIR_NAME', 1);
defined('SCAN_BASE_NAME') or define('SCAN_BASE_NAME', 2);
defined('SCAN_MULTI_ARRAY') or define('SCAN_MULTI_ARRAY', 3);
defined('SCAN_CAROUSEL_ARRAY') or define('SCAN_CAROUSEL_ARRAY', 4);
// максимальный размер выводимого изображения
defined('MAX_IMG_SIZE') or define('MAX_IMG_SIZE', 5*1024*1024);
// Paths
/**
 * путь к корневой папке сайта
 */
defined('ROOT') or define('ROOT', realpath(__DIR__ . DS . '..' . DS .'..' . DS . '..' . DS) . DS);
/**
 * путь к framework
 */
defined('SYS_DIR') or define('SYS_DIR', realpath(__DIR__. DS . '..' . DS. '..' . DS) . DS);
defined('FILES_DIR') or define('FILES_DIR', ROOT . 'files' . DS);
defined('DESIGN_DIR') or define('DESIGN_DIR', ROOT . 'design' . DS);
defined('VIEW_DIR') or define('VIEW_DIR', ROOT . 'view' . DS);
defined('TMP_DIR') or define('TMP_DIR', ROOT . 'tmp' . DS);
defined('BACKEND_DIR') or define('BACKEND_DIR', ROOT . 'backend' . DS);

set_include_path(ini_get('include_path') . PATH_SEPARATOR . __DIR__);
ini_set('session.auto_start', 1);

// защита страницы
defined('ACCESS') or define('ACCESS', true);

// директории сканирования конфигов
defined('CONFIGS_DEFAULT_PATH') or define('CONFIGS_DEFAULT_PATH', 'configs'.DS.'default');

// сканирование классов в автозагрузке
defined('DIR_CLASS_AUTOLOAD') or define('DIR_CLASS_AUTOLOAD', 'system, ajax, api, backend, captcha, payment, view');

@ini_set('allow_url_fopen', 1);
mb_internal_encoding('UTF-8');