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

/**
 * @param string $mod
 * @return bool
 */
function checkAdmControl($mod = 'index')
{

    if (!empty(auth()->user_info['control'])) {
        $access = array_map('trim', unserialize(auth()->user_info['control']));
        if (in_array($mod, $access)) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}



/**
 * @param $dir
 * @param int $buf
 * @return bool|int
 */
function dirsize($dir, $buf = 2)
{
    static $buffer;
    if (isset($buffer[$dir])) {
        return $buffer[$dir];
    }

    if (is_file($dir)) {
        return filesize($dir);
    }

    if ($dh = opendir($dir)) {
        $size = 0;
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $size += dirsize($dir . '/' . $file, $buf - 1);
        }
        closedir($dh);
        if ($buf > 0) {
            $buffer[$dir] = $size;
        }
        return $size;
    }
    return false;
}

/*
* Выводим чекбоксы :D
* $name - имя инпута чеки
* $val - тру ор фалсе
*/
/**
 * @param $name
 * @param $val
 * @return string
 */
function checkbox($name, $val)
{
    $checked = !empty($val) ? 'checked ' : false;
    return "<label class=\"checkbox checkbox-custom\"><input name=\"" . $name . "\" type=\"checkbox\" " . $checked . "><i class=\"checkbox\"></i></label>";
}


/*
* Выводим радио выбор Да Нет
* $name - имя инпута радио
* $val - тру ор фалсе
*/
/**
 * @param $name
 * @param $val
 * @return string
 */
function radio($name, $val)
{
    $but_1 = $val ? 'checked' : '';
    $but_2 = (!$val) ? 'checked' : '';
    return '
	<table>
	<tr>
	<td valign="top">
				<label class="radio radio-custom ' . $but_1 . '"><input type="radio" ' . $but_1 . ' value="1" name="' . $name . '" id="' . $name . '"><i class="radio ' . $but_1 . '"></i>' . _YES . '</label>
			</td>
			<td>&nbsp&nbsp</td>
			<td valign="top">
				<label class="radio radio-custom ' . $but_2 . '"><input type="radio" ' . $but_2 . ' value="0" name="' . $name . '" id="' . $name . '"><i class="radio ' . $but_2 . '"></i>' . _NO . '</label>
				</td>

	</tr>
	</table>';
}

/*
* Функция рекурсивного сканирования дерикторий
* $rootDir - директория
*/
/**
 * @param $rootDir
 * @param array $allData
 * @return array
 */
function scanDirectories($rootDir, $allData = array())
{
    $invisibleFileNames = array('.', '..', '.htaccess', '.htpasswd');
    /** @var array $dirContent */
    $dirContent = scandir($rootDir);
    foreach ($dirContent as $key => $content) {
        $path = $rootDir . '/' . $content;
        if (!in_array($content, $invisibleFileNames)) {
            if (is_file($path) && is_readable($path) && eregStrt('.tpl', $content)) {
                $allData[] = $path;
            } elseif (is_dir($path) && is_readable($path)) {
                $allData = scanDirectories($path, $allData);
            }
        }
    }
    return $allData;
}

/**
 * @param $srcdir
 * @param $dstdir
 * @param $offset
 * @param bool $verbose
 * @return string
 */
function dircopy($srcdir, $dstdir, $offset, $verbose = false)
{
    if (!isset($offset)) {
        $offset = 0;
    }
    $num = 0;
    $fail = 0;
    $sizetotal = 0;
    $fifail = '';
    if (!is_dir($dstdir)) {
        mkdir($dstdir, 0777);
        @chmod_R($dstdir, 0777);
    }
    if ($curdir = opendir($srcdir)) {
        while ($file = readdir($curdir)) {
            if ($file != '.' && $file != '..') {
                $srcfile = $srcdir . '\\' . $file;
                $dstfile = $dstdir . '\\' . $file;
                if (is_file($srcfile)) {
                    if (is_file($dstfile)) {
                        $ow = filemtime($srcfile) - filemtime($dstfile);
                    } else {
                        $ow = 1;
                    }
                    if ($ow > 0) {
                        if ($verbose) echo "Copying '$srcfile' to '$dstfile'...";
                        if (copy($srcfile, $dstfile)) {
                            touch($dstfile, filemtime($srcfile));
                            $num++;
                            $sizetotal = ($sizetotal + filesize($dstfile));
                            if ($verbose) echo "OK\n";
                        } else {
                            echo "Error: File '$srcfile' could not be copied!\n";
                            $fail++;
                            $fifail = $fifail . $srcfile . '|';
                        }
                    }
                } else if (is_dir($srcfile)) {
                    $res = explode(',', $ret);
                    $ret = dircopy($srcfile, $dstfile, $verbose);
                    $mod = explode(',', $ret);
                    $imp = array($res[0] + $mod[0], $mod[1] + $res[1], $mod[2] + $res[2], $mod[3] . $res[3]);
                    $ret = implode(',', $imp);
                }
            }
        }
        closedir($curdir);
    }
    $red = explode(',', $ret);
    $ret = ($num + $red[0]) . ',' . (($fail - $offset) + $red[1]) . ',' . ($sizetotal + $red[2]) . ',' . $fifail . $red[3];
    return $ret;
}


/**
 * @param $dirname
 */
function rmdir_rf($dirname)
{
    if ($dirHandle = opendir($dirname)) {
        chdir($dirname);
        while ($file = readdir($dirHandle)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($file)) {
                rmdir_rf($file);
            } else {
                unlink($file);
            }
        }
        chdir('..');
        rmdir($dirname);
        closedir($dirHandle);
    }
}

/**
 * @param $id
 * @param string $format
 * @return string
 */
function jsCalendar($id, $format = 'd.m.Y')
{
    if (is_array($id)) {
        $i = 0;
        foreach ($id as $k => $subId) {
            $i++;
            $subJs = "
			  <script type=\"text/javascript\">
			    window.addEvent('domready', function() { 
					myCal" . $i . " = new Calendar({ " . $subId . ": '" . $format . "' }, { classes: ['dashboard'], direction: 0 });
				});
			  </script>
			";
        }
    } else {
        $subJs = "
		  <script type=\"text/javascript\">
		    window.addEvent('domready', function() { 
				myCal2 = new Calendar({ " . $id . ": '" . $format . "' }, { classes: ['dashboard'], direction: 0 });
			});
		  </script>
		";
    }

    return '<script type="text/javascript" src="usr/plugins/calendar/mootools.js"></script><script type="text/javascript" src="usr/plugins/calendar/calendar.js"></script>' . $subJs . '<link rel="stylesheet" type="text/css" href="usr/plugins/calendar/dashboard.css" media="screen" />';

}

/*
* Определение pr сайта по урл
* $aUrl - урл сайта которого определяем
*/
/**
 * @param $aUrl
 * @return array|bool|int|string
 */
function getPageRank($aUrl)
{
    if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
        return 'Local PR 0';
    } else {
        $url = 'info:' . $aUrl;
        $ch = GCH(strord($url));
        $url = 'info:' . urlencode($aUrl);
        $pr = @file("http://www.google.com/search?client=navclient-auto&ch=6$ch&ie=UTF-8&oe=UTF-8&features=Rank&q=http://digits.ru/");
        $pr_str = @implode('', $pr);
        $pr = mb_substr($pr_str, strrpos($pr_str, ":") + 1);
        if ($pr > 1) {
            return $pr;
        } else {
            return 0;
        }
    }
}

/*
* Определение тиц сайта по урл
* $url - урл сайта которого определяем
*/
/**
 * @param $url
 * @return string
 */
function yandex_tic($url)
{
    if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
        return 'Local ТИЦ 0';
    } else {
        $ci_url = 'http://bar-navig.yandex.ru/u?ver=2&show=32&url=http://' . $url . '/';
        $ci_data = implode("", file("$ci_url"));
        preg_match("/value=\"(.\d*)\"/", $ci_data, $ci);
        if ($ci[1] == '') {
            $str = 0;
        } else {
            $str = $ci[1];
        }
        return trim($str);
    }
}