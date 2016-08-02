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

use Core as Instance;
use exception\ApplicationException;
use exception\ComponentException;

/**
 * Proxy Core
 *
 * Class Core
 * @package Proxy
 *
 * @method   static mixed|string InitLang()
 * @see      proxy\Core::InitLang()
 *
 * @method   static initCore()
 * @see      proxy\Core::initCore()
 *
 * @method   static buildUrls()
 * @see      proxy\Core::buildUrls()
 *
 * @method   static urlLang()
 * @see      proxy\Core::urlLang()
 *
 * @method   static LoadLang($module = true, $system = false, $admin = false)
 * @see      proxy\Core::LoadLang()
 *
 * @method   static loadLangFile($str)
 * @see      proxy\Core:: loadLangFile()
 *
 * @method   static loadModLang($mod)
 * @see      proxy\Core::loadModLang()
 *
 * @method   static loadModLangADM($mod)
 * @see      proxy\Core::loadModLangADM()
 *
 * @method   static mixed getLang($const)
 * @see      proxy\Core::getLang()
 *
 * @method   static setLang($lang)
 * @see      proxy\Core::setLang()
 *
 * @method   static array getLangList($force = false)
 * @see      proxy\Core::getLangList()
 *
 * @method   static array getModList()
 * @see      proxy\Core::getModList()
 *
 * @method   static string getMod($allowTemp = false)
 * @see      proxy\Core::getMod()
 *
 * @method   static mixed bbDecode($text, $pubId = 0, $html = false)
 * @see      proxy\Core::bbDecode()
 *
 * @method   static getCatList($parent, $module, $columns)
 * @see      proxy\Core::getCatList()
 *
 * @method   static string getCat($module, $pid = null, $type = 'short', $limit = 99)
 * @see      proxy\Core::getCat()
 *
 * @method   static string getCatImg($link, $img, $ctitle)
 * @see      proxy\Core::getCatImg()
 *
 * @method   static mixed catInfo($module, $cid)
 * @see      proxy\Core::catInfo()
 *
 * @method   static array|string aCatList($module = '')
 * @see      proxy\Core::aCatList()
 *
 * @method   static \Template setTpl($tpl)
 * @see      proxy\Core::setTpl()
 *
 * @method   static \Template tpl()
 * @see      proxy\Core::tpl()
 *
 * @method   static array getUrl()
 * @see      proxy\Core::getUrl()
 *
 * @method   static array setUrl($url)
 * @see      proxy\Core::setUrl()
 *
 */
class Core extends AbstractProxy
{
    /**
     * Init instance
     * @return Instance
     * @throws ApplicationException
     */
    protected static function initInstance()
    {
        try {
            return new Instance(new Config());
        } catch (\CoreException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param $key
     * @param $var
     * @throws ApplicationException
     */
    public static function setVar($key, $var)
    {
        try {
            static::getInstance()->tpl->vars[$key] = $var;
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param array $vars
     * @throws ApplicationException
     */
    public static function setVars($vars)
    {
        try {
            if (is_array($vars)) {
                foreach ($vars as $key => $var) {
                    static::getInstance()->tpl->vars[$key] = $var;
                }
            }
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param $text
     * @param $type
     * @throws ApplicationException
     */
    public static function info($text, $type = 'info')
    {
        try {
            static::getInstance()->tpl->info($text, $type);
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param $file
     * @param bool $check
     * @throws ApplicationException
     */
    public static function loadFile($file, $check = false)
    {
        try {
            static::getInstance()->tpl->loadFile($file, $check);
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function end()
    {
        try {
            static::getInstance()->tpl->end();
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param bool $return
     * @throws ApplicationException
     */
    public static function close($return = false)
    {
        try {
            static::getInstance()->tpl->close($return);
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param null $file
     * @throws ApplicationException
     */
    public static function open($file = null)
    {
        try {
            static::getInstance()->tpl->open($file);
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @throws ApplicationException
     */
    public static function head()
    {
        try {
            static::getInstance()->tpl->head();
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @param bool $subContent
     * @throws ApplicationException
     */
    public static function foot($subContent = false)
    {
        try {
            static::getInstance()->tpl->foot($subContent);
        } catch (ComponentException $e) {
            throw new ApplicationException($e);
        }
    }

    /**
     * @return mixed
     * @throws ComponentException
     */
    public static function auth()
    {
        return static::getInstance()->auth;
    }

    /**
     * @param      $page
     * @param      $num
     * @param      $all
     * @param      $link
     * @param bool $onClick
     *
     * @return mixed
     * @throws \exception\ComponentException
     */
    public static function pages($page, $num, $all, $link, $onClick = false)
    {
        return static::getInstance()->tpl->pages($page, $num, $all, $link, $onClick);
    }

    /**
     * @param $in
     *
     * @return mixed
     * @throws \exception\ComponentException
     */
    public static function parseAll($in)
    {
        return static::getInstance()->tpl->parseAll($in);
    }
}