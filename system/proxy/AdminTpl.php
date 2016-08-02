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

use AdminTpl as Instance;


/**
 * Proxy Session
 *
 * Class Session
 * @package Proxy
 *
 * @method   static __construct()
 * @see      proxy\AdminTpl::__construct()
 *
 * @method   static bool loadFile($file, $check = false)
 * @see     proxy\AdminTpl::loadFile()
 *
 * @method   static admin_head($title = null)
 * @see     proxy\AdminTpl::admin_head()
 *
 * @method   static admin_foot($last_visit = null, $last_ip = null)
 * @see     proxy\AdminTpl::admin_foot()
 *
 * @method   static string blockCookie($block, $type = 'block')
 * @see     proxy\AdminTpl::blockCookie()
 *
 * @method   static a_pages($page, $num, $all, $link, $onClick = false)
 * @see     proxy\AdminTpl::a_pages()
 *
 * @method   static string getThemeFile($file)
 * @see     proxy\AdminTpl::getThemeFile()
 *
 * @method   static loadFileADM($file, $check = false)
 * @see     proxy\AdminTpl::loadFileADM()
 *
 * @method   static bool check_phone()
 * @see     proxy\AdminTpl::check_phone()
 *
 * @method   static setVar($k, $v)
 * @see     proxy\AdminTpl::setVar()
 *
 * @method   static setVarBlock($k, $v)
 * @see     proxy\AdminTpl::setVarBlock()
 *
 * @method   static setVarTPL($k, $v)
 * @see     proxy\AdminTpl::setVarTPL()
 *
 * @method   static parse()
 * @see     proxy\AdminTpl::parse()
 *
 * @method   static bool preOpen($content)
 * @see     proxy\AdminTpl::preOpen()
 *
 * @method   static bool preTitle($content)
 * @see     proxy\AdminTpl::preTitle()
 *
 * @method   static string enUrl($urlGo, $lang)
 * @see     proxy\AdminTpl::enUrl()
 *
 * @method   static string ustinf($tag)
 * @see     proxy\AdminTpl::ustinf()
 *
 * @method   static bool return_end()
 * @see     proxy\AdminTpl::return_end()
 *
 * @method   static end()
 * @see     proxy\AdminTpl::end()
 *
 * @method   static head()
 * @see     proxy\AdminTpl::head()
 *
 * @method   static foot($subContent = false)
 * @see     proxy\AdminTpl::foot($subContent = false)
 *
 * @method   static bool loadTPL($file)
 * @see     proxy\AdminTpl::loadTPL()
 *
 * @method   static open($file = null)
 * @see     proxy\AdminTpl::open()
 *
 * @method   static bool close($return = false)
 * @see     proxy\AdminTpl::close()
 *
 * @method   static bool title($text, $return = false)
 * @see     proxy\AdminTpl::title()
 *
 * @method   static info($text, $type = 'info', $redicret = null, $time = null, $url = null)
 * @see     proxy\AdminTpl::info()
 *
 * @method   static redicret($message, $url = 'news', $text = 'Спасибо')
 * @see     proxy\AdminTpl::redicret()
 *
 * @method   static bool|null|string blockParse($file = null, $type = null)
 * @see     proxy\AdminTpl::blockParse()
 *
 * @method   static bool blockShow()
 * @see     proxy\AdminTpl::blockShow($mods, $unmods, $groups, $free = false)
 *
 * @method   static pages($page, $num, $all, $link, $onClick = false)
 * @see     proxy\AdminTpl::pages()
 *
 */
class AdminTpl extends AbstractProxy
{
    /**
     * Init instance
     *
     * @return Instance
     */
    protected static function initInstance()
    {
        return new Instance();
    }
}