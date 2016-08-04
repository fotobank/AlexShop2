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


namespace core;

use Exception;
use exception\BaseException;
use helper\Recursive\Recursive;
use Tracy\Debugger;


/** @noinspection PhpIncludeInspection */
include(SYS_DIR . 'exception/IException.php');
/** @noinspection PhpIncludeInspection */
include(SYS_DIR . 'exception/BaseException.php');
/** @noinspection PhpIncludeInspection */
include(SYS_DIR . 'helper/Recursive/Recursive.php');


/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class AutoloadException extends BaseException
{
}


/**
 * Class Autoloader
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class Autoloader extends Recursive
{

    // папка кэша и лога
    public $dir_cashe = 'assests/cache/autoload';

    // имя файла кэша без слэша
    public $file_array_class_cache = 'class_cache.php';

    // файлы в заданных директориях отобранные по маске
    public $file_array_scan_files = 'scan_files.php';

    // файл лога создается при новом рекурсивном сканировании классов или если класс не найден
    public $fileLog = 'log.html';

    // расширение файлов у искомых классов
    public $files_ext = ['.php', '.class.php'];

    // массив путей поиска файлов классов
    public $paths = [];

    // файл настройки
    public $htaccess = '.htaccess';

    // данные файла настройки
    public $htaccess_data
        = <<<END
<Files *.html, *.php>
Order deny,allow
Deny from all
</Files>
END;
    // заголовок файл лога
    protected $head = <<<END
<html lang="en">
<head>
<title>Log autoload class</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Alex" />
<meta name="generator" content="Alex" />
</head>
<body>
END;

    // кэш соответствия неймспейса пути в файловой системе
    /**
     * @var array
     */
    protected $array_class_cache = [];

    // массив всех файлов в сканируемых папкак, отобранных по заданным расширениям
    protected $array_scan_files = [];

    // namespace класса
    protected $name_space;

    // имя класса
    protected $class_name;

    // имя файла класса
    protected $class_file_name;


    /**
     * конструктор класса
     * @throws AutoloadException
     */
    public function __construct()
    {
        try {
            $this->paths = explode(',', DIR_CLASS_AUTOLOAD);
            spl_autoload_extensions('.php');
            /** назначаем метод автозагрузки */
            spl_autoload_register(['Core\\Autoloader', 'autoload']);

            /** переопределение свойств  */
            $this->dir_cashe = SYS_DIR . $this->setDirSep($this->dir_cashe) . DS;
            $this->fileLog = $this->dir_cashe . $this->fileLog;
            $this->file_array_class_cache = $this->dir_cashe . $this->file_array_class_cache;
            $this->file_array_scan_files = $this->dir_cashe . $this->file_array_scan_files;
            $this->htaccess = $this->dir_cashe . $this->htaccess;
            /** проверить директории кэша и задать права */
            $this->checkDir();
            /** проверка и создание .htaccess */
            $this->createFile($this->htaccess, $this->htaccess_data);
            /** если файла кэша нет - создать */
            $this->createFile($this->file_array_class_cache, '');
            /** если файла лога */
            $this->createFile($this->fileLog, $this->head);
            /** читаем кэш в массив из файла */
            $this->array_class_cache = $this->getFileMap();
            /** если файл скана директорий существует - загрузить его в память
             * иначе - отсканировать папку, создать файл и загрузить в память  */
            if (false === $this->createFile($this->file_array_scan_files, '')) {
                $this->array_scan_files = $this->arrFromFile($this->file_array_scan_files);
            } else {
                $this->updateScanFiles();
            }
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $parh
     * @return mixed
     */
    protected function setDirSep($parh)
    {
        return str_replace(['\\', '/'], DS, $parh);
    }

    /**
     * проверить директории и установить права
     * @throws AutoloadException
     */
    protected function checkDir()
    {
        try {
            if (!is_dir($this->dir_cashe)) {
                mkdir($this->dir_cashe, 0711, true);
            }
            if (!is_writable($this->dir_cashe)) {
                chmod($this->dir_cashe, 0711);
            }
            if (!is_dir($this->dir_cashe) || !is_writable($this->dir_cashe)) {
                throw new AutoloadException('can not create "' . $this->dir_cashe . '" an unwritable dir <br>');
            }
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $file
     *
     * если файла нет - создать и установить права
     *
     * @param $data
     *
     * @return bool
     * @throws AutoloadException
     */
    protected function createFile($file, $data)
    {
        if (!file_exists($file)) {
            if (false === file_put_contents($file, $data, LOCK_EX)) {
                throw new AutoloadException("can not create '{$file}' an unwritable dir '{$this->dir_cashe}'<br>");
            }
            chmod($file, 0600);

            return true;
        }

        return false;
    }

    /**
     * чтение файла кэша в массив
     *
     * @return array
     * @throws AutoloadException
     */
    private function getFileMap()
    {
        $file_string = file_get_contents($this->file_array_class_cache);
        if ($file_string === false) {
            throw new AutoloadException('Can not read the file "' . $this->file_array_class_cache . '"');
        }

        return parse_ini_string($file_string);
    }

    /**
     * mixed arrFromFile - функция восстановления данных массива из файла
     *
     * @param string $filename - имя файла откуда будет производиться восстановление данных
     *
     * @return mixed
     * @throws AutoloadException
     */
    protected function arrFromFile($filename)
    {
        if (file_exists($filename)) {
            $file = file_get_contents($filename);
            $value = unserialize($file);

            if ($value === false) {
                $this->updateScanFiles();
                $file = file_get_contents($filename);
                $value = unserialize($file);
            }

            return $value;
        }
        throw new AutoloadException(
            "не найден путь файла '{$filename}' <br>"
        );
    }

    /**
     * создание массива файлов заданных директорий
     * с фильтрацией по расширению
     *
     * @throws AutoloadException
     */
    protected function updateScanFiles()
    {
        try {
            foreach ($this->paths as $path) {
                $path = trim($this->setDirSep($path));
                //  $this->array_scan_files = $this->rScanDir(ROOT . $path . DS);
                $path = ROOT . $path . DS;
                $this->array_scan_files = $this->scanDir($path, ['php'], SCAN_BASE_NAME);
            }
            $this->arrToFile($this->array_scan_files, $this->file_array_scan_files);
            $this->updateScanFilesLog();
        } catch (Exception $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * void arrToFile - функция записи массива в файл
     *
     * @param mixed $value - объект, массив и т.д.
     * @param string $filename - имя файла куда будет произведена запись данных
     *
     * @return void
     *
     */
    protected function arrToFile($value, $filename)
    {
        $str_value = serialize($value);
        file_put_contents($filename, $str_value, LOCK_EX);
    }

    /**
     * запись в лог техничесского сообщения
     * @throws AutoloadException
     */
    private function updateScanFilesLog()
    {
        try {
            if (DEBUG_LOG) {
                $this->putLog('<b style="background-color: #ffffaa;">сканируем директории и обновляем базу поиска классов</b>');
            }
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $data
     *
     * запись лога в файл
     *
     * @throws AutoloadException
     */
    private function putLog($data)
    {
        try {
            $data = ('[ ' . $data . ' => ' . date('d.m.Y H:i:s') . ' ]<br>' . PHP_EOL);
            file_put_contents($this->fileLog, $data, FILE_APPEND | LOCK_EX);
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $class_name
     * автозагрузчик файлов классов
     *
     * @return bool
     * @throws AutoloadException
     */
    public function autoload($class_name)
    {
        try {
            $this->name_space = '';
            /** подготовка имени в классах с namespace */
            $lastNsPos = strrpos($class_name, '\\');
            if ($lastNsPos) {
                $this->name_space = $this->setDirSep(substr($class_name, 0, $lastNsPos));
                $this->class_name = substr($class_name, $lastNsPos + 1);
                if(false === $this->findClass()) {
                    return false;
                }
            }
            /** попытка поиска без namespace ( если namespace отличается от вложенности директорий ) */
            $this->class_name = $class_name;
            if(false === $this->findClass()) {
                return false;
            }

            /** сообщение в log - класс не найден */
            $this->logLoadError($class_name);
            if(DEBUG_MODE)
            {
             //   throw new AutoloadException('Class "' . $class_name . '"  not found');
            }

        } catch (AutoloadException $e) {
            Debugger::log($e, Debugger::ERROR); // also sends an email notification
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     *
     * @return bool
     * @throws AutoloadException
     */
    private function findClass()
    {
        try {

            /** проверка нахождения класса в кэш */
            if (false === $this->checkClassNameInCash()) {
                return false;
            }
            /** искать в базе найденных файлов классов */
            /** если не найден - обновить информацию в кэше рекурсивного сканирования */
            if ($this->checkClassNameInBaseScanFiles()) {

                $this->updateScanFiles();
                return $this->checkClassNameInBaseScanFiles();
            } else {
                // успешно найден
                return false;
            }
            
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * проверка нахождения класса в кэш
     *
     * @return bool
     */
    protected function checkClassNameInCash()
    {
        foreach ($this->files_ext as $ext) {
            $file_name = basename($this->class_name . $ext, '.php');
            $ext = substr(strrchr($ext, '.'), 0);

            $class_name_space = $file_name;
            if (!empty($this->name_space)) {
                $class_name_space = $this->name_space . DS . $file_name;
            }
            if (array_key_exists($class_name_space, $this->array_class_cache) &&
                !empty($this->array_class_cache[$class_name_space])) {
                // проверка на правильность пути в кэше если есть $this->name_space
                // если путь неправильный(имена классов совпадают) - выход
                $filePath = $this->array_class_cache[$class_name_space] . DS . $file_name . $ext;
                if (file_exists($filePath)) {
                    /** @noinspection PhpIncludeInspection */
                    require_once $filePath;
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * @return bool
     * @throws AutoloadException
     */
    private function checkClassNameInBaseScanFiles()
    {
        try {

            foreach ($this->files_ext as $ext) {

                $file_basename_name = $this->class_file_name = basename($this->class_name . $ext, '.php');
                $ext = substr(strrchr($ext, '.'), 0);

                /** проверка с namespace */
                if ($this->name_space != '' && array_key_exists($file_basename_name, $this->array_scan_files)) {
                    foreach ($this->array_scan_files[$file_basename_name] as $key => $path_class) {
                        $path_class = $this->setDirSep($path_class);
                        $expression = str_replace(['\\'], '\\\\', $this->name_space);
                        $match = preg_match('/' . $expression . '/', $path_class);
                        $file = $path_class . DS . $file_basename_name . $ext;
                        if ($match && !file_exists($file)) {

                            /** если не найден - обновить информацию в кэше рекурсивного сканирования */
                            $this->updateScanFiles();
                            // читаем новый путь
                            $path_class = $this->setDirSep($this->array_scan_files[$file_basename_name][$key]);
                        }
                        if ($match && false === $this->checkClass($path_class, $file_basename_name, $ext)) {
                            // класс найден
                            return false;
                        }
                    }
                }
                /** ищем класс с незаданным namespace */
                if (array_key_exists($file_basename_name, $this->array_scan_files)) {
                    $arr_path_class = $this->array_scan_files[$file_basename_name];
                    foreach ($arr_path_class as $key => $path_class) {
                        if (false === $this->checkClass($path_class, $file_basename_name, $ext)) {
                            return false;
                        }
                    }
                }
            }
            // класс не найден
            return true;
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $full_path
     * @param $file_name
     * @param $ext
     *
     * @return bool
     *
     * проверка физичесского наличия файла класса в директории
     * и запись кэша
     * @throws AutoloadException
     */
    private function checkClass($full_path, $file_name, $ext)
    {
        try {
            $file = $full_path . DS . $file_name . $ext;
            $file_name = ($this->name_space != '') ? $this->name_space . DS . $file_name : $file_name;
            $class_name = ($this->name_space != '') ? $this->name_space . '\\' . $this->class_name : $this->class_name;
            $this->logFindClass($full_path, $file_name . $ext);

            if (file_exists($file)) {
                /** @noinspection PhpIncludeInspection */
                require_once($file);
                if (class_exists($class_name) or interface_exists($class_name) or trait_exists($class_name)) {
                    $this->logLoadOk($full_path . DS, $file_name . $ext);
                    $this->addNamespace($full_path, $file_name);
                    $this->putFileMap($file_name . ' = ' . $full_path . PHP_EOL);
                    return false;
                }
            }
            return true;
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $file_path
     * @param $file
     *
     * запись в лог начала поиска файла
     *
     * @throws AutoloadException
     */
    private function logFindClass($file_path, $file)
    {
        if (DEBUG_LOG) {
            $this->putLog('ищем файл "' . $file . '" in ' . $file_path);
        }
    }

    /**
     * @param $full_path
     * @param $file
     *
     * запись успешного подключения класса в лог
     *
     * @throws AutoloadException
     */
    private function logLoadOk($full_path, $file)
    {
        if (DEBUG_LOG) {
            $this->putLog('<b style="color: #23a126;">подключили  </b>' . '<b style="color: #3a46e1;"> ' .
                $full_path . '</b>' . '<b style="color: #ff0000;">' . $file . '</b>');
        }
    }

    /**
     * @param string $full_path
     *
     * @param string $file_name
     *
     * @return bool добавление найденного пути класса в массив
     *
     * добавление найденного пути класса в массив
     */
    public function addNamespace($full_path, $file_name)
    {
        if (is_dir($full_path)) {
            $this->array_class_cache[$file_name] = $full_path;
        }
    }

    /**
     * @param $class
     *
     * @return bool проверка существования записи в файле кэша классов и, если надо, изменение строк
     * проверка существования записи в файле кэша классов и, если надо, изменение строк
     * @throws AutoloadException
     * @internal param $data
     */
    private function putFileMap($class)
    {
        try {
            $class = trim($class);
            $file_map = $this->getFileMap();
            list($file_name, $file_patch) = explode('=', $class);
            $file_patch = trim($file_patch);
            $file_name = trim($file_name);

            if (array_key_exists($file_name, $file_map)) {
                $full_name_map = $file_name . ' = ' . $file_map[$file_name];
                /** если пути не равны */
                if ($full_name_map != $class) {
                    /** изменить строку в массиве и записать изменения в файл */
                    $file_map[$file_name] = $file_patch;
                    $file_map_write = '';
                    foreach ($file_map as $drop_name_class => $file) {
                        $file_map_write .= $drop_name_class . ' = ' . $file . PHP_EOL;
                    }
                    /** перезаписываем файл */
                    file_put_contents($this->file_array_class_cache, $file_map_write, LOCK_EX);
                    unset($file_map);
                }
            } else {
                /** или добавить запись */
                file_put_contents($this->file_array_class_cache, $class . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }

    /**
     * @param $class_name
     *
     * @throws AutoloadException
     */
    private function logLoadError($class_name)
    {
        try {
            if (DEBUG_LOG) {
                $this->putLog('<b style="color: #ff0000;">Класс "' . $class_name . '" не найден</b>');
            }
        } catch (AutoloadException $e) {
            throw new AutoloadException($e->getMessage());
        }
    }
}
