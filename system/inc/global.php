<?php
/**
 * Framework Component
 * @name      ALEX_CMS
 * @author    Alex Jurii <jurii@mail.ru>
 * The MIT License (MIT)
 * Copyright (c) 2016
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */


if (!defined('ACCESS')) {
    header('Location: /');
    exit;
}

use proxy\Config;
use proxy\Core;
use proxy\Db;
use proxy\Session;


/**
 * @param $str
 *
 * @return string
 */
function processText($str)
{
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    $str = addslashes($str);
    return $str;
}

/**
 * @param $title
 *
 * @return mixed|string
 */
function prepareTitle($title)
{
    $title = htmlspecialchars(stripslashes($title), ENT_QUOTES);
    $title = str_replace('&amp;', '&', $title);

    return $title;
}

/**
 * @param $points
 * @param $exgroup
 *
 * @return mixed
 */
function get_exgroup($points, $exgroup)
{
    if ($exgroup > 0 && isset(auth()->groups_array[$exgroup])) {
        return auth()->groups_array[$exgroup];
    } elseif ($points > 0 && $exgroup == 0) {
        foreach (auth()->groups_array as $id => $arr) {
            if ($arr['special'] == 1 && $points >= $arr['points'] && $arr['points'] > 0) {
                return $arr;
            }
        }
    }
}

/**
 * @param $uid
 * @param $conf
 */
function user_points($uid, $conf)
{
    $user = Config::getData('user');
    if ($user['count_points'] == 1) {
        $points_conf = Config::getData('points_conf');
        $where = is_numeric($uid) ? "WHERE `id`='" . (int)$uid . "'" : "WHERE `nick`='" . filter($uid, 'nick') . "'";
        if (isset($points_conf[$conf])) {
            Db::getQuery('UPDATE `' . USER_DB . '`.`' . USER_PREFIX . "_users` SET `points` = `points`+'" .
                (int)$points_conf[$conf] . "' " . $where . ' LIMIT 1 ;');
        }
    }
}


/**
 * @param string $str
 *
 * @return string
 */
function engine_encode($str = '')
{
    $config = Config::getData('config');
    $result = '';

    for ($i = 0, $len = strlen($str); $i < $len; $i++) {
        $result .= '#' . strtr(ord($str[$i]), $config['uniqKey'], strrev($config['uniqKey']));
    }

    return $result;
}

/**
 * @param string $str
 *
 * @return string
 */
function engine_decode($str = '')
{
    $config = Config::getData('config');
    $result = '';
    $str = explode('#', $str);

    for ($i = 0, $len = count($str); $i < $len; $i++) {
        if (empty($str[$i])) {
            continue;
        }

        $result .= chr(strtr($str[$i], strrev($config['uniqKey']), $config['uniqKey']));
    }

    return $result;
}

/**
 * Сохраняем кэш
 * $file - файл(без разрещения .cache) который находится в tmp/cache
 * $data - то что запишем в кэш
 *
 * @param      $file
 * @param      $data
 * @param bool $conf
 *
 * @return bool
 */
function setcache($file, $data, $conf = false)
{
    $allowCahce = Config::getData('allowCahce');
    if (isset($allowCahce[$file]) && $allowCahce[$file] == 0) {
        return true;
    }
    if (isset($allowCahce[$conf]) && $allowCahce[$conf] == 0) {
        return true;
    }
    if ($data) {
        $data = serialize($data);
        $dir = ROOT . 'tmp/cache/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
            @chmod_R($dir, 0777);
            greateFilesLock($dir);
        }
        $fp = @fopen($dir . trim($file) . '.cache', 'w');
        fwrite($fp, $data);
        fclose($fp);
        @chmod(ROOT . 'tmp/cache/' . trim($file) . '.cache', 0777);
        return true;
    }
}

/**
 * создаем файлы защиты директории кеша
 *
 * @param $dir
 */
function greateFilesLock($dir)
{
    file_put_contents($dir . '.htaccess', 'deny from all', LOCK_EX);
    file_put_contents($dir . 'index.html', '', LOCK_EX);
}

/**
 * @param $file
 *
 * @return bool
 */
function is_cache($file)
{
    return file_exists(ROOT . 'tmp/cache/' . trim($file) . '.cache');
}

/**
 * Получаем кэш из файла
 * $file - файл(без разрещения .cache) который находится в tmp/cache
 *
 * @param $file
 *
 * @return
 */
function getcache($file)
{
    $core = Core::getInstance();
    if (empty($core->cacheContent[md5($file)])) {
        $path = ROOT . 'tmp/cache/' . trim($file) . '.cache';
        if (file_exists($path)) {
            $core->cacheContent[md5($file)] = unserialize(file_get_contents($path));
            return $core->cacheContent[md5($file)];
        }
    } else {
        return $core->cacheContent[md5($file)];
    }
}

/**
 * @param $file
 */
function delcache($file)
{
    $path = SYS_DIR . 'tmp/cache/' . trim($file) . '.cache';
    !is_file($path) ?: unlink($path);
}

/**
 * Сжимаем файлики
 * $scr - полный адресс к файлу( ROOT.'/')
 *
 * @param $src
 */
function compress($src)
{
    $log_conf = Config::getData('log_conf');
    if (file_exists($src) && filesize($src) > $log_conf['compressSize']) {
        $fp = fopen($src, 'r');
        $data = fread($fp, filesize($src));
        fclose($fp);

        $name = explode('.', basename($src));
        $dst = ROOT . 'tmp/archives/' . $name[0] . '_' . time() . '.gz';
        $zp = gzopen($dst, 'w9');
        if (gzwrite($zp, $data)) {
            unlink($src);
        }
        gzclose($zp);
    }
}

/**
 * @param        $type
 * @param string $obj
 */
function checkType($type, $obj = 'all')
{
    $files_conf = Config::getData('files_conf');
    echo $files_conf['attachFormats'] . 'df';
    switch ($obj) {
        case 'all':
            $parseStr = $files_conf['imgFormats'] . ',' . $files_conf['attachFormats'];
            $typeArr = explode(',', $parseStr);
            $types = [];
            foreach ($typeArr as $type) {
                if (trim($type) != '') {
                    $types[] = $type;
                }
            }

            if (in_array($type, $types)) {
                echo 'ok';
            }
            break;

        case 'image':
            $parseStr = $files_conf['imgFormats'];
            $typeArr = explode(',', $parseStr);
            $types = [];
            foreach ($typeArr as $type) {
                if (trim($type) != '') {
                    $types[] = $type;
                }
            }

            if (in_array($type, $types)) {
                echo 'ok';
            }
            break;

        case 'attach':
            $parseStr = $files_conf['attachFormats'];
            $typeArr = explode(',', $parseStr);
            $types = [];
            foreach ($typeArr as $type) {
                if (trim($type) != '') {
                    $types[] = $type;
                }
            }

            if (in_array($type, $types)) {
                echo 'ok';
            }
            break;
    }

}

/**
 * Красиво выводим массивы
 * $var - переменную которую будем обрабатывать
 *
 * @param $var
 */
function prt($var)
{
    echo '<pre>';
    /** @noinspection ForgottenDebugOutputInspection */
    print_r($var);
    echo '</pre>';
}

/**
 * @param $startTime
 *
 * @return string
 */
function getTime($startTime)
{
    $result = '';
    $time = time() - $startTime;

    $s = (int)($time % 60);
    $m = (int)($time / 60 % 60);
    $h = (int)($time / 3600 % 24);
    $d = (int)($time / 86400 % 30);

    if ($m > 0) {
        $result = $m . _MINUTE_AGO;
        if ($m < 4) {
            $result = _NOW;
        }
    }

    if ($h > 0) {
        $result = $h . declension($h, [' час', ' часа', ' часов']) . _HOUR_AGO;
    }

    if ($d > 0) {
        $result = $d . _DAY_AGO;
    }

    if (emptY($result)) {
        if ($m == 0) {
            $result = _NOW;
        } else {
            $result = $s . _SEC_AGO;
        }
    }

    return $result;
}

/**
 * Форматируем юникс дату
 * $time - это время в юникс формате(time();)
 * $simple - если true то даты будут выглядеть просто
 *
 * @param      $time
 * @param bool $simple
 *
 * @return string
 */
function formatDate($time, $simple = false)
{
    if ((time() - $time) < 43200 && $time < time()) {
        return getTime($time);
    }
    $format = '';
    $months = [null, _MJAN, _MFEB, _MMAR, _MAPR, _MMAY, _MJUN, _MJUL, _MAUG, _MSEP, _MOCT, _MNOV, _MDEC];
    $month = $months[gmdate('n', $time)];

    if ($simple || $time > time()) {
        $format .= gmdate('d', $time) . ' ' . $month;
    } else {
        if (gmdate('d.m.y', $time) == gmdate('d.m.y', time())) {
            $format .= _TODAY; // сегодня
        } elseif (gmdate('d.m.y', $time) == gmdate('d.m.y', time() - 86400)) {
            $format .= _YESTERDAY; // вчера
        } else {
            $format .= gmdate('d', $time) . ' ' . $month . ' ' . gmdate('Y', $time);
        }
    }

    $format .= ', ' . gmdate('H:i', $time);

    return $format;
}

/**
 * Обрезаем текст
 * $text - это собственно текст который режем
 * $max - максимальное кол-во символов
 *
 * @param $text
 * @param $max
 *
 * @return string
 */
function str($text, $max)
{
    if (mb_strlen($text, 'UTF-8') > $max) {
        return mb_substr($text, 0, $max, 'utf-8') . '...';
    } else {
        return $text;
    }
}

/**
 * Функция транслита текста
 * $text - это собственно текст который будем преобразовывать
 */
function translit($string, $tochka = '')
{
    $string = filter($string, 'a');
    $arr = ['ж' => 'zh', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shh', 'э' => 'je', 'ю' => 'ju', 'я' => 'ja', 'ъ' => '', 'ь' => '', '.' => $tochka];
    $str = ["а", "б", "в", "г", "д", "е", "з", "и", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "ц", "ъ", "ы", "ь"];
    $str_to = ["a", "b", "v", "g", "d", "e", "z", "i", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "с", "", "y", ""];
    $result = mb_strtolower(trim(strip_tags($string)), 'UTF-8');
    $result = preg_replace('/\s+/ms', '-', $result);
    $result = str_replace($str, $str_to, $result);
    $result = str_replace(array_keys($arr), array_values($arr), $result);
    $result = preg_replace('/[^a-z0-9\_\-.]+/mi', '', $result);
    $result = preg_replace('#[\-]+#i', '-', $result);

    return mb_substr($result, 0, 40);
}

/*
* Отображаем превью картинки
*/
/**
 * @param $img
 * @param $type
 *
 * @return mixed
 */
function img_preview($img, $type)
{
    switch ($type) {
        case 'box':
            return $img;
            break;
    }
}

/**
 * Устанавливаем титл <title></title> страницы сайта
 * $array - массив из титлов (array('Главная', 'Новости'))
 *
 * @param $array
 */
function set_title($array)
{
    $config = Config::getData('config');
    if (is_array($array)) {
        $title_massiv = array_reverse($array);
        Core::tpl()->title = false;
        foreach ($title_massiv as $title) {
            if ($title) {
                Core::tpl()->title .= filter($title) . $config['divider'];
            }
        }
    }
}

/**
 * Форматируем размер файла в байтах
 * $size - размер в байтах
 *
 * @param      $size
 * @param bool $short
 *
 * @return string
 */
function formatfilesize($size, $short = false)
{
    if (is_numeric($size)) {
        if ($short) {
            $filesizename = [" b", " kb", " mb", " gb", " tb", " pb", " eb", " ZB", " YB"];
        } else {
            $filesizename = [" " . _BYTE, " " . _KBYTE, " " . _MBYTE, " " . _GBYTE, ' ' . _TBYTE, " PB", " EB", " ZB", " YB"];
        }

        return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 ' . _BYTE;
    } else {
        return $size;
    }
}

/*
* Получаем адресс без http и www
* $uri - полный адресс
*/
/**
 * @param $uri
 *
 * @return mixed|string
 */
function getHost($uri)
{
    $uri = str_replace(['http://', 'www.'], '', $uri);
    $uri = explode('/', $uri);

    return mb_strtolower($uri[0]);
}

/*
* Подсвечиваем слова поиска)
* $textShort = highlightSearch('php ajax', $news['short']);
* $words - слова разделить пробелом пример "php ajax css"
* $text - то что обработаем
*/
/**
 * @param $words
 * @param $text
 *
 * @return mixed
 */
function highlightSearch($words, $text)
{
    $searchWords = explode(' ', $words);
    foreach ($searchWords as $word) {
        if (!preg_match('/([^<>]+)/i', $word)) {
            $text = str_ireplace($word, "<span class=\"highlightSearch\">$word</span>", $text);
        }
    }
    return $text;
}

/**
 * @param $array
 *
 * @return mixed
 */
function mjsEnd($array)
{
    $page = array_search('page', $array);
    if ($page) {
        return $array[$page - 1];
    } else {
        return end($array);
    }
}

/**
 * @param $module
 * @param $altname
 *
 * @return string
 */
function initDC($module, $altname)
{
    return 'files/' . $module . '/' . translit($altname);
}

/**
 * @param $reg
 *
 * @return mixed
 */
function configMatch($reg)
{
    return str_replace(['*', '%'], ['.+', '.+'], $reg);
}

/**
 * @param $mod
 *
 * @return string
 */
function modAccess($mod)
{

    if (isset(Core::tpl()->modules[$mod])) {
        $groups = explode(',', Core::tpl()->modules[$mod]['groups']);
        if (empty($groups[0]) OR in_array(auth()->group, $groups)) {
            return 'groupOk';
        } else {
            return 'groupError';
        }
    }

    return 'nonMod';
}

/**
 * @param $msg
 * @param $type
 */
function writeInLog($msg, $type)
{
    $dir = SYS_DIR . 'assests/log/';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
        @chmod_R($dir, 0777);
        greateFilesLock($dir);
    }
    $logPath = $dir . $type . '.log';

    if (file_exists($logPath)) {
        $data = unserialize(@file_get_contents($logPath));
    }

    $data[] = ['msg'   => $msg,
               'ip'    => $_SERVER['REMOTE_ADDR'],
               'url'   => isset($_REQUEST['url']) ? filter($_REQUEST['url']) : '',
               'agent' => filter($_SERVER['HTTP_USER_AGENT']),
               'time'  => time(),
    ];

    $data = serialize($data);
    $fp = @fopen($logPath, 'w');
    fwrite($fp, $data);
    fclose($fp);
}

/**
 * @param $file
 *
 * @return mixed|string
 */
function getExt($file)
{
    $arr = explode('.', $file);
    return mb_strtolower(end($arr));
}

/**
 * @param      $fname
 * @param      $thumb_fname
 * @param int  $max_x
 * @param int  $max_y
 * @param bool $resp
 *
 * @return bool|string
 */
function createThumb($fname, $thumb_fname, $max_x = 99, $max_y = 99, $resp = false)
{
    $ext = getExt($thumb_fname);

    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            $im = imagecreatefromjpeg($fname);
            break;

        case 'gif':
            $im = imagecreatefromgif($fname);
            break;

        case 'png':
            $im = imagecreatefrompng($fname);
            break;

        default:
            return false;
            break;
    }

    if (@$im) {
        list($width, $height, $type, $attr) = getimagesize($fname);
        if (($width > $max_x) or ($height > $max_y)) {
            if ($width > $height) {
                $nw = $max_x;
                $nh = ($max_x / $width) * $height;
            } else {
                $nw = ($max_y / $height) * $width;
                $nh = $max_y;
            }

            $thumb = imagecreatetruecolor($nw, $nh);
            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $nw, $nh, $width, $height);
            imagejpeg($thumb, $thumb_fname, 90);
            imagedestroy($thumb);
        } else {
            if ($resp == true) {
                return 'orig';
            } else {
                copy($fname, $thumb_fname);
            }
        }
    } else {
        return false;
    }
}


/**
 * @param $uid
 *
 * @return mixed
 */
function avatar($uid)
{
    static $avatar = [];
    $user = Config::getData('user');

    if (empty($avatar[$uid])) {
        $arr_avatar = glob(ROOT . 'files/avatars/users/av' . $uid . '.*');
        if ($arr_avatar) {
            foreach ((array)$arr_avatar as $av) $avatar[$uid] = 'files/avatars/users/' . basename($av);
        } else {
            $avatar[$uid] = $user['noAvatar'];
        }
    }

    return $avatar[$uid];
}

/**
 * @param $uid
 */
function deleteAvatar($uid)
{
    $arr_avatar = glob(ROOT . 'files/avatars/users/av' . $uid . '.*');
    if ($arr_avatar) {
        foreach ((array)$arr_avatar as $av) @unlink($av);
    }
}

/**
 * @param int $gid
 *
 * @return mixed
 */
function groupName($gid = -1)
{

    static $groupNames = [];
    if ($gid == -1) $gid = auth()->group;

    if (empty($groupNames[$gid])) {
        if (auth()->group_info['color'] != '') {
            $groupNames[$gid] = '<span style="color:' . auth()->group_info['color'] . ';">' . auth()->group_info['gname'] . '</span>';
        } else {
            $groupNames[$gid] = auth()->group_info['gname'];
        }
    }

    return $groupNames[$gid];
}

/**
 * @param      $id
 * @param      $module
 * @param      $score
 * @param      $votes
 * @param null $blocked
 *
 * @return string|void
 */
function draw_rating($id, $module, $score, $votes, $blocked = null)
{
    $news_conf = Config::getData('news_conf');
    if (auth()->group_info['allowRating'] == 0) {
        return false;
    }

    if (isset($news_conf['carma_rate']) && $news_conf['carma_rate'] == 1) {
        $button_plus = defined('AJAX') ? '' : '<img src="usr/tpl/' . Core::tpl()->tplDir . '/assest/images/engine/up.gif" border="0" alt="' . _PLUS_CARMA . '" title="' . _PLUS_CARMA . '" align="middle" class="_pointer" onclick="do_carma(' . $id . ', 1)" />';
        $button_minus = defined('AJAX') ? '' : '<img src="usr/tpl/' . Core::tpl()->tplDir . '/assest/images/engine/down.gif" border="0" alt="' . _MINUS_CARMA . '" title="' . _MINUS_CARMA . '" align="middle" class="_pointer" onclick="do_carma(' . $id . ', 2)" />';
        $summ = $news_conf['carma_summ'] ? (((int)$score - $votes) > 0 ? '<span class="rating_plus">+' . ((int)$score - $votes) . '</span>' :
            (((int)$score - $votes) == 0 ? '<span class="rating_zero">0</span>' : '<span class="rating_minus">' . ((int)($score) - $votes) . '</span>')) : (($score + $votes) > 0 ? '<span class="rating_plus">' . ($score > 0 ? '+' . (int)($score) :
                (int)($score)) . '</span> <span class="rating_minus">' . ($votes > 0 ? '-' . $votes : $votes) . '</span>' : '<span class="rating_zero">0</span>');

        $rating = '<div id="rating' . $id . '" class="rating_layer">' . $button_plus . $summ . $button_minus . '</div>';
        return $rating;
    } else {
        static $limitStar, $starStyle;

        if (empty($limitStar) && empty($starStyle)) {

            $confName = mb_strtolower($module) . '_conf';
            $$confName = Config::getData($confName);
            
            if (isset($$confName)) {
                $subArray = $$confName;
            }


            if (isset($subArray['limitStar']) && $subArray['limitStar'] > 3) {
                $limitStar = (int)$subArray['limitStar'];
            } else {
                $limitStar = 5;
            }

            if (isset($subArray['starStyle']) && !empty($subArray['starStyle'])) {
                $starStyle = $subArray['starStyle'];
            } else {
                $starStyle = 'star-rating';
            }
        }

        $starWidth = Core::tpl()->starWidth;
        if (!defined('AJAX')) {
            $rating = '<div><div id="rating' . $id . '"></div></div>';
            if ($blocked == 0) echo '<div id="rat' . $id . '" style="display:none;"></div>';
            $rating .= '<script type="text/javascript">genRating(\'' . $starStyle . '\',\'' . $starWidth . '\',\'' . $limitStar . '\',\'' . $score . '\',\'' . $votes . '\',\'' . $blocked . '\',\'' . $id . '\',\'' . $module . '\', \'' . _RATING . ': ' . mb_substr(($votes == 0) ? 0 : ($score / $votes), 0, 3) . ' ' . _VOTES . ': ' . $votes . '\');</script>';
        } else {
            $rating = '\'' . $starStyle . '\',\'' . $starWidth . '\',\'' . $limitStar . '\',\'' . $score . '\',\'' . $votes . '\',\'' . $blocked . '\',\'' . $id . '\',\'' . $module . '\', \'' . _RATING . ': ' . mb_substr(($votes == 0) ? 0 : ($score / $votes), 0, 3) . ' ' . _VOTES . ': ' . $votes . '\'';
        }
        return $rating;
    }
}

/**
 * @param $content
 * @param $uid
 *
 * @return string
 */
function checkCommentGuest($content, $uid)
{
    if ($uid == 0) {
        return stripslashes($content);
    }
}

/**
 * Отслеживаем ботов
 * $agent - $_SERVER['HTTP_USER_AGENT']
 * $ret_id - если true то функция вернёт ид бота
 * $id - если известен ид бота то скрипт вернёт его имя
 */
function SpiderDetect($agent, $ret_id = false, $id = null)
{
    $engines = [
        ['Aport', 'Aport robot'],
        ['Google', 'Google'],
        ['msnbot', 'MSN'],
        ['Rambler', 'Rambler'],
        ['Yahoo', 'Yahoo'],
        ['AbachoBOT', 'AbachoBOT'],
        ['accoona', 'Accoona'],
        ['AcoiRobot', 'AcoiRobot'],
        ['ASPSeek', 'ASPSeek'],
        ['CrocCrawler', 'CrocCrawler'],
        ['Dumbot', 'Dumbot'],
        ['FAST-WebCrawler', 'FAST-WebCrawler'],
        ['GeonaBot', 'GeonaBot'],
        ['Gigabot', 'Gigabot'],
        ['Lycos', 'Lycos spider'],
        ['MSRBOT', 'MSRBOT'],
        ['Scooter', 'Altavista robot'],
        ['AltaVista', 'Altavista robot'],
        ['WebAlta', 'WebAlta'],
        ['IDBot', 'ID-Search Bot'],
        ['eStyle', 'eStyle Bot'],
        ['Mail.Ru', 'Mail.Ru Bot'],
        ['Scrubby', 'Scrubby robot'],
        ['Yandex', 'Yandex'],
        ['VoidSearch', 'VoidSearch'],
        ['YaDirectBot', 'Yandex Direct']
    ];

    if ($id) {
        return $engines[$id][1];
    } else {
        foreach ($engines as $key => $engine) {
            if (strstr($agent, $engine[0])) {
                if ($ret_id == false) {
                    return ($engine[1]);
                } else {
                    return $key;
                }
            }
        }
    }

    return false;
}

/**
 * @param      $url
 * @param      $cookies
 * @param bool $reffer
 */
function setHeaders($url, $cookies, $reffer = false)
{
    $config = Config::getData('config');
    static $cookie;
    $reffer = $reffer == false ? $config['url'] : $reffer;
    if (trim($cookies) != '' && get_loaded_extensions('curl')) {
        if (!isset($cookie)) {
            $cookie = '';
            $bufferCookie = array_unique(explode("\n", $cookies));

            foreach ($bufferCookie as $cook) {
                if (trim($cook) != '' && eregStrt('=', $cook)) {
                    $cookie .= $cook . '; ';
                }
            }
        }

        $curl_handle = curl_init($url);
        curl_setopt($curl_handle, CURLOPT_COOKIE, $cookie);
        curl_setopt($curl_handle, CURLOPT_REFERER, $reffer);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, randomUserAgent());
        curl_exec($curl_handle);
        curl_close($curl_handle);
    }
}

/**
 * @return mixed
 */
function randomUserAgent()
{
    $agents = ['Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; ru) Opera 8.01', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows 98)', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.6) Gecko/20050225 Firefox/1.0.1', 'Mozilla/4.0 (compatible; MSIE 5.01; Windows 98)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MyIE2; .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Maxthon)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1) Opera 7.50 [en]', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.10) Gecko/20050717 Firefox/1.0.6', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MRA 3.0 (build 00614))', 'Mozilla/5.0 (Windows; U; Windows NT 5.0; ru-RU; rv:1.7.10) Gecko/20050717 Firefox/1.0.6', 'Opera/6.01 (Windows 2000; U) [ru]', 'Mozilla/5.0 (Windows; U; Windows NT 5.0; ru-RU; rv:1.7.7) Gecko/20050414 Firefox/1.0.3', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts-MyWay; MRA 4.2 (build 01102))', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; snprtz|dialno; HbTools 4.7.0)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; MRA 4.0 (build 00768))', 'Mozilla/4.0 (compatible; MSIE 5.5; Windows 98; Win 9x 4.90; OptusIE55-31)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MRA 4.1 (build 00961); .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MRA 4.1 (build 00975); .NET CLR 1.1.4322)', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; MRA 4.2 (build 01102))', 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; Hotbar 4.6.1)', 'Mozilla/4.0 (compatible; MSIE 5.0; Windows 98)', 'Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows 2000) Opera 7.0 [en]', 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT 5.0)', 'Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.8a5) Gecko/20041122'];
    return $agents[mt_rand(0, count($agents) - 1)];
}

/**
 * @param $lenght
 *
 * @return string
 */
function gencode($lenght)
{
    $code = [];
    $symbols = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '2', '3', '4', '5', '6', '7', '8', '9'];
    for ($i = 0; $i < $lenght; $i++) {
        $code[] = $symbols[mt_rand(0, count($symbols) - 1)];
    }

    return implode('', $code);
}

/**
 * @param bool $button
 *
 * @return string
 */
function captcha_image($button = true)
{
    $security = Config::getData('security');
    $captcha = 'капча отключена, ввод не требуется';
    if ($security['switch_cp'] != 0) {
        if ($security['recaptcha'] == 0) {
            Session::start();
            $captcha = "<style type=\"text/css\">/* <![CDATA[ */.captcha{width: " . $security['captcha_width'] . "px; height: " . $security['captcha_height'] . "px; background: url('captcha') top left no-repeat;}/* ]]> */</style><a href=\"javascript:reloadCaptcha();\" title=\"' . _REFRESH . '\"><div class=\"captcha\" id=\"captcha\"> </div></a>";
        } else {
            $publickey = $security['recaptcha_public'];
            $privatekey = $security['recaptcha_private'];
            $captcha = '<div class="g-recaptcha" data-sitekey="' . $publickey . '"></div><script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=ru"></script>';
        }
    }
    return $captcha;
}

/**
 * @param $post_name
 *
 * @return bool
 */
function captcha_check($post_name)
{
    $security = Config::getData('security');
    if ($security['switch_cp'] != 0) {
        if ($security['recaptcha'] == 0) {
            Session::start();
            if (auth()->isUser) {
                return true;
            }
            if (isset($_REQUEST[$post_name])) {
                if (isset($_SESSION['securityCode'])) {
                    if ($_SESSION['securityCode'] == mb_strtolower($_POST[$post_name])) {
                        unset($_SESSION['securityCode']);
                        return true;
                    }
                } else {
                    echo 'session failed';
                }
            }
        } else {
            $publickey = $security['recaptcha_public'];
            $privatekey = $security['recaptcha_private'];
            $recaptcha = new Recaptcha($privatekey);
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if ($resp->isSuccess()) {
                return true;
            } else {
                $errors = $resp->getErrorCodes();

            }
        }
    } else {
        return true;
    }
    return false;

}

/**
 * @param $value
 */
function parse_req($value)
{
    $log_conf = Config::getData('log_conf');
    if (!is_array($value)) {
        if (preg_match("#UNION|OUTFILE|SELECT|ALTER|INSERT|DROP|TRUNCATE#i", base64_decode($value))) {
            if ($log_conf['queryError'] == 1) writeInLog('Попытка произвести SQL-Inj текст: ' . $value, 'sql');
            //fatal_error(_ERROR, _UNKNOWN_ERROR);
            die();
        }
    } else {
        foreach ($value as $val) {
            parse_req($val);
        }
    }
}

/**
 * @param $file
 *
 * @return array
 */
function loadConfig($file)
{
    $lang = Config::getData('config')['lang'];
    if ($lang != Core::getInstance()->lang && file_exists(SYS_DIR . 'configs/default/' . Core::getInstance()->lang . '.' . $file . '.yml')) {
        return Config::getData(Core::getInstance()->lang . ' . ' . $file);
    }
    return Config::getData($file);
}

/**
 * @param $file
 */
function loadConfigBLOCK($file)
{
    $lang = Config::getData('config')['lang'];
    $mainFile = ROOT . 'etc/blocks/' . $file . '.config.php';
    if (file_exists($mainFile)) {
        require_once($mainFile);
    }
    if ($lang != Core::getInstance()->lang && file_exists(ROOT . 'etc/blocks/' .
            Core::getInstance()->lang . '.' . $file . '.config.php')
    ) {
        require ROOT . 'etc/blocks/' . Core::getInstance()->lang . '.' . $file . '.config.php';
    }
}


/**
 * @return bool
 */
function loadUserAuth()
{
    Session::start();
    if (isset($_SESSION['user_auth'])) {
        return $_SESSION['user_auth'];
    } else {
        return false;
    }
}

/**
 * @return string
 */
function social_list()
{
    $social = Config::getData('social');
    $config = Config::getData('config');

    $s_list = '';

    if ($social['vk_is'] == '1') {
        $s_list .= '<a href="' . $config['url'] . '/auth.php?url=vk"><img  src="media/social/Vk.png" alt="Вконтакте" width="32" height="32"> </a>';
    }

    if ($social['ok_is'] == '1') {
        $s_list .= '<a href="' . $config['url'] . '/auth.php?url=odnoklassniki"><img  src="media/social/Odnoklassniki.png" alt="Одноклассники" width="32" height="32"> </a>';
    }

    if ($social['fb_is'] == '1') {
        $s_list .= '<a href="' . $config['url'] . '/auth.php?url=facebook"><img  src="media/social/Facebook.png" alt="Facebook" width="32" height="32"> </a>';
    }

    if ($social['mm_is'] == '1') {
        $s_list .= '<a href="' . $config['url'] . '/auth.php?url=mailru"><img  src="media/social/Mailru.png" alt="Mail.ru" width="32" height="32"> </a>';
    }

    if ($social['gg_is'] == '1') {
        $s_list .= '<a href="' . $config['url'] . '/auth.php?url=google"><img  src="media/social/Google.png" alt="Google" width="32" height="32"> </a>';
    }

    if ($social['ya_is'] == '1') {
        $s_list .= '<a href="' . $config['url'] . '/auth.php?url=yandex"><img  src="media/social/Yandex.png" alt="Яндекс" width="32" height="32"> </a>';
    }

    return $s_list;
}



/**
 * @param      $text
 * @param bool $type
 *
 * @return mixed|string
 */
function filter($text, $type = false)
{
    $security = Config::getData('security');
    $wordReplace = [];
    $stopWords = explode(',', $security['stopWords']);
    foreach ((array)$stopWords as $word) {
        $wordReplace[$word] = $security['stopReplace'];
    }

    $text = str_replace('||men||', '<', $text);
    $text = str_replace('||and||', '&', $text);
    $text = str_replace('||bol||', '>', $text);
    $text = str_replace(array_keys($wordReplace), array_values($wordReplace), $text);

    switch ($type) {
        case 'bb':
        default:
            $text = htmlspecialchars((string)$text);
            break;

        case 'title':
            $text = htmlspecialchars((string)htmlspecialchars_decode($text), ENT_QUOTES);
            break;

        case 'int':
            $text = (int)$text;
            break;

        case 'str':
            $text = ((string)$text);
            break;

        case 'mail':
            $text = ((preg_match("/^[A-Z0-9_.-]+@([A-Z0-9][A-Z0-9-]+.)+[A-Z]{2,6}$/iu", $text)) ? mb_strtolower($text) : '');
            break;

        case 'url':
            $text = preg_replace("'[^A-ZА-Яa-zа-я0-9_ -.,\\[\\]\\)\\(-\\@!?\$&*~]'ius", '', $text);
            break;

        case 'html':
            $text = (preg_replace(array_keys(Core::getInstance()->deniedHTML),
                array_values(Core::getInstance()->deniedHTML), (string)$text));
            break;

        case 'alphanum':
            $text = preg_replace("'[^A-ZА-Яa-zа-я0-9_ -.,\\[\\]]'ius", '', $text);
            break;

        case 'nick':
            $text = preg_replace("'[^A-ZА-Яa-zа-я0-9_ -.,\\[\\]\\)\\(-\\@!?\$&*~]'ius", '', $text);
            break;


        case 'no_html':
            $text = htmlspecialchars(strip_tags(urldecode((string)$text)));
            break;

        case 'provider':

            if (!($text == 'vk' || $text = 'yandex' || $text = 'mailru' || $text = 'google' || $text = 'facebook' || $text = 'odnoklassniki')) {
                $text = '';
            }
            break;

        case 'dir':
            $text = preg_replace("'([^a-z0-9_/-]|[/]*$)'iu", '', $text);
            $text = preg_replace("'[/]{2,}'", '/', $text);
            break;

        case 'ip':
            if (!preg_match("'[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}'", $text)) {
                $text = null;
            }
            break;

        case 'reqUri':
            break;

        case 'forBB':
            $text = str_replace("\n", '<br/>', $text);
            break;
    }

    if ($type != 'template') {
        $text = preg_replace('/{%([^%]*)%}/i', '&#123;%\\1%}', $text);
    }

    return $text;
}

/**
 * @param $what
 * @param $where
 * @return int
 */
function eregStrt($what, $where)
{
    $rez = preg_match("@$what@i", $where);
    return $rez;
}

/**
 * Ограничение групп для шаблонов
 * $group - группы для которых закрыть доступ через ,
 * $content - то что прячем
 *
 * @param $group
 * @param $content
 *
 * @return bool|string
 */
function noGroup($group, $content)
{

    $gr_array = explode(',', $group);
    if (in_array(auth()->group, $gr_array)) {
        return false;
    } else {
        return stripslashes($content);
    }
}

/**
 * Ограничение групп для шаблонов
 * $group - группы для которым показывать ,
 * $content - то что прячем
 *
 * @param $group
 * @param $content
 *
 * @return bool|string
 */
function Group($group, $content)
{

    $gr_array = explode(',', $group);
    if (!in_array(auth()->group, $gr_array)) {
        return false;
    } else {
        return stripslashes($content);
    }
}

/**
 * Условия для шаблонов и не только ;)
 * $content - то что проверяем
 * $data - то что выводим
 *
 * @param $condition
 * @param $data
 *
 * @return string
 */
function if_set($condition, $data)
{
    return empty($condition) ? '' : stripslashes($data);
}

/**
 * @param $content
 *
 * @return string
 */
function checkUser($content)
{

    if (auth()->isUser) {
        return stripslashes($content);
    }
}

/**
 * @param $content
 *
 * @return string
 */
function checkAdmin($content)
{

    if (auth()->isAdmin) {
        return stripslashes($content);
    }
}

/**
 * @param $content
 *
 * @return string
 */
function checkGuest($content)
{

    if (auth()->isUser == false) {
        return stripslashes($content);
    }
}

/**
 * @param $content
 *
 * @return string
 */
function checkCaptcha($content)
{
    $security = Config::getData('security');
    if ($security['switch_cp'] == 1) {
        return stripslashes($content);
    }
}

/**
 * @param $content
 *
 * @return string
 */
function checkSocial($content)
{
    if (Config::getData('social')['switch'] == 1) {
        return stripslashes($content);
    }
}

/**
 * @param $is
 * @param $content
 *
 * @return string
 */
function checkReCaptcha($is, $content)
{
    if ($is > 0) {
        if (Config::getData('security')['recaptcha'] == 1) {
            return stripslashes($content);
        }
    } else {
        if (Config::getData('security')['recaptcha'] == 0) {
            return stripslashes($content);
        }
    }
}

/**
 * Генерация ссылок для страничной навы
 * $link - ссылка модуля
 * $content - то что выводим
 * $type - номер страницы
 *
 * @param      $link
 * @param      $content
 * @param      $type
 * @param bool $onClick
 *
 * @return string
 */
function pageLink($link, $content, $type, $onClick = false)
{
    return '<a href="' . str_replace('{page}', 'page/' . $type, $link) . '" title="' . $content . '" ' . ($onClick ? str_replace('{num}', $type, $onClick) : '') . '><b>' . $content . '</b></a> ';
}

/**
 * Форматинг ссылки для новости
 * $title - имя ссылки
 * $format - адресс сылки
 *
 * @param $title
 * @param $format
 *
 * @return string
 */
function format_link($title, $format)
{
    return "<a href=\"" . $format . "\" title=\"{%TITLE%}\">" . stripslashes($title) . '</a>';
}

/**
 * @param $text
 * @param $limit
 *
 * @return bool|string
 */
function truncate_words($text, $limit)
{
    $text = mb_substr($text, 0, $limit);
    if (mb_strlen($text) == $limit && mb_substr($text, mb_strlen($text) - 1, 1)) {
        $textret = mb_substr($text, 0, mb_strlen($text) - mb_strlen(strrchr($text, ' ')));
        if (!empty($textret)) {
            return $textret;
        }
    }
    if (strlen($text) > $limit) {
        $text = mb_substr($text, 0, $limit);
    }
    return $text;
}


/**
 * @param $count
 * @param $text
 *
 * @return bool|string
 * обрезка строки в короткой новости
 */
function short($count, $text)
{
    $text = strip_tags($text);
    $text_f = $text;
    if (strlen($text) > $count) {
        $text = truncate_words($text, $count);
        if ($text_f != $text) {
            $text .= '...';
        }
    }
    return $text;
}

/**
 * Показывать только на главной или везде кроме главной? :)
 * $is - true или false отображать ТОЛЬКО на главной или КРОМЕ главной)
 * $content - контент
 *
 * @param $is
 * @param $content
 *
 * @return string
 */
function indexShow($is, $content)
{
    $is = (int)$is;

    if ($is > 0) {
        if (defined('INDEX_NOW')) {
            return stripslashes($content);
        }
    } else {
        if (!defined('INDEX_NOW')) {
            return stripslashes($content);
        }
    }
}

/**
 * Показывать контент только в определенных модулях
 * $modules - модули в которых показывать через ,(запятую)
 * $content - контент
 *
 * @param $modules
 * @param $content
 *
 * @return bool|string
 */
function moduleShow($modules, $content)
{
    $modulesArray = explode(',', $modules);

    if (in_array(Core::getUrl()[0], $modulesArray)) {
        return stripslashes($content);
    } else {
        return false;
    }
}

/**
 * @param $modules
 * @param $tag
 * @param $content
 *
 * @return string
 */
function modulesShow($modules, $tag, $content)
{

    $modulesArray = explode(',', $modules);

    if (in_array(Core::getUrl()[0], $modulesArray)) {
        if ($tag == 1) {
            return stripslashes($content);
        }
    } else {
        if ($tag == 0) {
            return stripslashes($content);
        }
    }

}

/**
 * @param $category
 * @param $tag
 * @param $content
 *
 * @return string
 */
function categoryShow($category, $tag, $content)
{
    $url = Core::getUrl();
    $categoryArray = explode(',', $category);
    if ($url[0] == 'news' || $url[0] == 'content') {
        $where = "altname='" . $url[1] . "'";
        $query = Db::getQuery('SELECT * FROM ' . DB_PREFIX . '_categories WHERE ' . $where . ' LIMIT 1');
        $row = Db::getRow($query);
        $id_now = $row['id'];
        if (in_array($id_now, $categoryArray)) {
            if ($tag == 1) {return stripslashes($content);}
        } else {
            if ($tag == 0) {return stripslashes($content);}
        }
    }
}

/**
 * @param $news
 * @param $tag
 * @param $content
 *
 * @return string
 */
function newsShow($news, $tag, $content)
{
    $url = Core::getUrl();
    $newsArray = explode(',', $news);
    if ($url[0] == 'news') {
        if (eregStrt('.html', $url[1])) {
            $altname = $url[1];

        } else {
            $altname = $url[2];
        }
        $altname = str_replace('.html', '', $altname);
        $where = "altname='" . $altname . "'";
        $query = Db::getQuery('SELECT * FROM ' . DB_PREFIX . '_news WHERE ' . $where . ' LIMIT 1');
        $row = Db::getRow($query);
        $id_now = $row['id'];
        if (in_array($id_now, $newsArray)) {
            if ($tag == 1) {return stripslashes($content);}
        } else {
            if ($tag == 0) {return stripslashes($content);}
        }
    }
}

/**
 * @param $news
 * @param $tag
 * @param $content
 *
 * @return string
 */
function contentShow($news, $tag, $content)
{
    $url = Core::getUrl();
    $newsArray = explode(',', $news);
    if ($url[0] == 'content') {
        if (eregStrt('.html', $url[1])) {
            $altname = $url[1];

        } else {
            $altname = $url[2];
        }
        $altname = str_replace(".html", "", $altname);
        $where = "translate='" . $altname . "'";
        $query = Db::getQuery("SELECT * FROM " . DB_PREFIX . "_content WHERE " . $where . " LIMIT 1");
        $row = Db::getRow($query);
        $id_now = $row['id'];
        if (in_array($id_now, $newsArray)) {
            if ($tag == 1) return stripslashes($content);
        } else {
            if ($tag == 0) return stripslashes($content);
        }
    }
}


/**
 * @param $is
 * @param $content
 *
 * @return string
 */
function addnewsShow($is, $content)
{
    $url = Core::getUrl();
    $is = (int)$is;

    if ($is > 0) {
        if (($url[1] == 'addPost') || ($url[1] == 'savePost')) {
            return stripslashes($content);
        }
    } else {
        if (($url[1] != 'addPost') && ($url[1] != 'savePost')) {
            return stripslashes($content);
        }
    }
}

/**
 * @param $is
 * @param $content
 *
 * @return string
 */
function fullnewsShow($is, $content)
{
    $url = Core::getUrl();
    $is = (int)($is);

    if ($is > 0) {
        if (eregStrt('.html', $url[1]) || eregStrt('.html', $url[2])) {
            return stripslashes($content);
        }
    } else {
        if (!(eregStrt('.html', $url[1]) || eregStrt('.html', $url[2]))) {
            return stripslashes($content);
        }
    }
}


/**
 * @param string $category
 * @param string $template
 * @param string $aviable
 * @param string $limit
 * @param string $module
 * @param string $order
 * @param string $short
 * @param bool   $notin
 *
 * @return mixed
 */
function buildCustom($category = '', $template = '', $aviable = '', $limit = '', $module = '', $order = '', $short = '', $notin = false)
{

    $category = filter($category, 'a');
    $template = filter($template, 'a');
    $aviable = filter($aviable, 'a');
    $limit = (int)($limit);
    $module = filter($module, 'module');

    if (!empty($category) && !empty($template) && !empty($aviable) && ($limit > 0) && !empty($module) && file_exists(ROOT . 'usr/modules/' . $module . '/custom.php')) {
        if ($aviable == 'all' || ($aviable != 'all' && modulesShow($aviable, 1, 'on') == 'on')) {
            require(ROOT . 'usr/modules/' . $module . '/custom.php');

            return $custom;
        }
    }
}

/**
 * @param $html
 *
 * @return mixed
 */
function _getCustomImg($html)
{
    preg_match_all('#<img[^>]+src=[\'"]([^\s>]*)[\'"][^>]*>#is', $html, $images);
    return $images[1];
}

/**
 * @param $text
 *
 * @return mixed|string
 */
function clearTEXT($text)
{

    $search = ["'ё'",
        "'<script[^>]*?>.*?</script>'si",  // Вырезается javascript
        "'<[\/\!]*?[^<>]*?>'si",           // Вырезаются html-тэги
        "'([\r\n])[\s]+'",                 // Вырезается пустое пространство
        "'&(quot|#34);'i",                 // Замещаются html-элементы
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d+);'e"];
    $replace = ["е",
        " ",
        " ",
        "\\1 ",
        "\" ",
        " ",
        " ",
        " ",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)"];
    $text = preg_replace($search, $replace, $text);
    $del_symbols = [",", ".", ";", ":", "\"", "#", "\$", "%", "^",
        "!", "@", "`", "~", "*", "-", "=", "+", "\\",
        "|", "/", ">", "<", "(", ")", "&", "?", "¹", "\t",
        "\r", "\n", "{", "}", "[", "]", "'", "“", "”", "•"

    ];
    $text = str_replace($del_symbols, [" "], $text);
    $text = ereg_replace('( +)', ' ', $text);
    return $text;
}

/**
 * @param $xfields
 * @param $id
 * @param $content
 *
 * @return string
 */
function ifFields($xfields, $id, $content)
{
    if (empty($xfields)) {
        return '';
    } else {
        $fields = unserialize($xfields);
        if (!empty($fields[$id][1])) {
            return stripslashes($content);
        } else {
            return '';
        }
    }
}


/**
 * @param $path
 * @param $age_days
 *
 * Удаляет старые файлы из заданного каталога
 */
function delete_old_files($path, $age_days)
{
    if ($handle = opendir($path))
    {
        while (false !== ($fil = readdir($handle)))
        {
            if ($fil != '.' && $fil != '..')
            {
                clearstatcache();
                $fn = $path. '/' .$fil;
                if (is_dir($fn)) {continue;}
                $diff = floor((time()-filemtime($fn))/(24*3600));
                if ($diff>=$age_days)
                {
                    @unlink($fn);
                }
            }
        }
        closedir($handle);
    }
}