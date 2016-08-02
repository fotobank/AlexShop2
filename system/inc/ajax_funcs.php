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

use proxy\Core;
use proxy\Db;

function blockList()
{
    echo '<thead>
            <tr>
                <th><span class="pd-l-sm"></span>ID</th>
                <th class="col-md-3">' . _TITLE . '</th>
                <th class="col-md-2">' . _TYPE . '</th>
                <th class="col-md-1">' . _CONTENT . '</th>
                <th class="col-md-2">' . _TEMPLATE . '</th>
                <th class="col-md-2">Полож.</th>
                <th class="col-md-3">' . _ACTIONS . '</th>
                <th class="col-md-1">
                    <input type="checkbox" name="all" onclick="setCheckboxes(\'tablesForm\', true); return false;" />
                </th>
            </tr>
        </thead>
        <tbody>';
    $queryTypes = Db::getQuery('SELECT * FROM ' . DB_PREFIX . '_blocks_types ORDER BY title ASC');
    while ($_type = Db::getRow($queryTypes)) $_types[$_type['type']] = $_type['title'];

    $query = Db::getQuery('SELECT * FROM ' . DB_PREFIX . "_plugins WHERE service='blocks' ORDER BY type ASC, priority ASC");
    if (Db::numRows($query) > 0) {
        $blocks = [];
        while ($result = Db::getRow($query)) {
            $blocks[$result['type']][] = $result;
            $countType[$result['type']] = true;
        }
        foreach ($blocks as $type => $inf) {
            $count[$type] = count($blocks[$type]);
            foreach ($inf as $number => $result) {
                $up = '';
                $down = '';
                if ($number > 0) {
                    $up = '<a href="javascript:void(0)" onclick="adminBlock(\'moveUp\', \'' . $result['id'] . '\',  \'' . $blocks[$type][$number - 1]['id'] . '\', \'' . $result['priority'] . '\', \'' . $blocks[$type][$number - 1]['priority'] . '\');" title="Передвинуть вверх">
					
					<button type="button" class="btn btn-info btn-outline btn-rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Передвинуть вверх"><i class="fa fa-angle-up "></i></button>
					
					</a>';
                }

                if ($number != $count[$type] - 1) {
                    $down = '<a href="javascript:void(0)" onclick="adminBlock(\'moveDown\', \'' . $result['id'] . '\',  \'' . $blocks[$type][$number + 1]['id'] . '\', \'' . $result['priority'] . '\', \'' . $blocks[$type][$number + 1]['priority'] . '\');" title="Передвинуть вниз">
					
					<button type="button" class="btn btn-info btn-outline btn-rounded" data-toggle="tooltip" data-placement="top" title="" data-original-title="Передвинуть вниз"><i class="fa fa-angle-down"></i></button>
					
					</a>';
                }

                $active = ($result['active'] == 1) ? '<a href="javascript:void(0)" onclick="adminBlockStatus(\'' . $result['id'] . '\', 0);" title="' . _DEACTIVATE . '"  class="deactivate"><button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="' . _DEACTIVATE . '">D</button></a>' : '<a href="javascript:void(0)" onclick="adminBlockStatus(\'' . $result['id'] . '\', 1);" title="' . _ACTIVATE . '"  class="activate"><button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="' . _ACTIVATE . '">A</button></a>';

                /** @noinspection HtmlUnknownTarget */
                echo '
				<tr>
					<td><span class="pd-l-sm"></span>' . $result['id'] . '</td>
					<td>' . $result['title'] . '</td>
					<td>' . (isset($_types[$result['type']]) ? $_types[$result['type']] : '') . '</td>
					<td>' . ($result['file'] ? $result['file'] : 'HTML-контент') . '</td>
					<td>' . ($result['template'] ? $result['template'] : _NO) . '</td>
					<td>' . $up . $down . '</td>
					<td>' . $active . '
						<a href="' . ADMIN . '/blocks/add/' . $result['id'] . '">
						<button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="' . _EDIT . '">E</button>
						</a>
						<a href="javascript:void(0)" onclick="blockDelete(' . $result['id'] . ');" title="' . _DELETE . '" class="delete">
						<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="' . _DELETE . '">X</button>
						</a>					
					</td>
					<td> <input type="checkbox" name="checks[]" value="' . $result['id'] . '"></td>
				</tr>';
            }
        }
        echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody>';
    }
}

function setBlockStatus()
{

    if (auth()->isAdmin) {
        $id = (int)$_REQUEST['id'];
        $to = (int)$_REQUEST['to'];
        Db::getQuery('UPDATE `' . DB_PREFIX . "_plugins` SET `active` = '" . $to . "' WHERE `id` =" . $id . ' LIMIT 1 ;');
        delcache('plugins');
        blockList();
    }
}

function version_check()
{
    echo VERSION_ID;
}

function setCommentStatus()
{

    if (auth()->isAdmin) {
        $id = (int)$_REQUEST['id'];
        $to = (int)$_REQUEST['to'];
        Db::getQuery('UPDATE `' . DB_PREFIX . "_comments` SET `status` = '" . $to . "' WHERE `id` =" . $id . ' LIMIT 1 ;');
        if ($to == 1) {
            echo 'Выкл.';
        } else {
            echo 'Вкл.';
        }
    }
}

function deleteBlock()
{

    if (auth()->isAdmin) {
        $id = (int)$_REQUEST['id'];
        Db::getQuery('DELETE FROM `' . DB_PREFIX . '_plugins` WHERE `id` = ' . $id . ' LIMIT 1');
        delcache('plugins');
        blockList();
    }
}

function inputTags()
{
    $query = filter(utf_decode($_REQUEST['query']), 'a');
    $input = filter($_REQUEST['input'], 'a');

    $query = trim(end(explode(',', $query)));

    $tags = Db::getQuery('SELECT tag FROM ' . DB_PREFIX . "_tags WHERE tag LIKE '%" . Db::safesql($query) . "%' AND module='news'");
    if ($query && Db::numRows($tags) > 0) {
        echo '<ul>';
        $tag_s = [];
        while ($rows = Db::getRow($tags)) $tag_s[$rows['tag']] = $rows['tag'];

        $tagg = array_unique($tag_s);
        foreach ($tagg as $tagme) {
            echo '<li><a href="javascript:void(0)" onclick="gid(\'' . $input . '\').value = tagSplit(gid(\'' . $input . '\').value, \'' . $tagme . '\'); showhide(\'check_result2\');">' . $tagme . '</a>';
        }

        echo '</ul>';
    } else {
        echo '<ul>';
        echo '<li>Подходящих тэгов нет';
        echo '</ul>';
    }
}

function moveUp()
{

    if (auth()->isAdmin) {
        $id = (int)$_REQUEST['id'];
        $to = (int)$_REQUEST['to'];
        $from = (int)$_REQUEST['from'];
        $topos = (int)$_REQUEST['topos'];

        if ($from == $topos) {
            $topos = $from + 1;
        }

        if ($topos < $from) {
            $topos = $from + 1;
        }

        Db::getQuery('UPDATE `' . DB_PREFIX . "_plugins` SET `priority` = '" . $topos . "' WHERE `id` =" . $to . ' LIMIT 1 ;');
        Db::getQuery('UPDATE `' . DB_PREFIX . "_plugins` SET `priority` = '" . $from . "' WHERE `id` =" . $id . ' LIMIT 1 ;');
        delcache('plugins');
        blockList();
    }
}


function moveDown()
{

    if (auth()->isAdmin) {
        $id = (int)$_REQUEST['id'];
        $to = (int)$_REQUEST['to'];
        $from = (int)$_REQUEST['from'];
        $topos = (int)$_REQUEST['topos'];

        if ($from == $topos) {
            $topos = $from - 1;
        }

        if ($topos < $from) {
            $topos = $from - 1;
        }

        Db::getQuery('UPDATE `' . DB_PREFIX . "_plugins` SET `priority` = '" . $from . "' WHERE `id` =" . $to . ' LIMIT 1 ;');
        Db::getQuery('UPDATE `' . DB_PREFIX . "_plugins` SET `priority` = '" . $topos . "' WHERE `id` =" . $id . ' LIMIT 1 ;');

        blockList();
    }
}

function getPreview()
{

    $title = utf_decode($_REQUEST['title']);
    $short = utf_decode($_REQUEST['shortNews']);
    $full = utf_decode($_REQUEST['fullNews']);
    echo '<div class="genPreview">';
    if (!empty($title) && !empty($short)) {
        echo "<style>#sb-body,#sb-loading{background-color:#f2f2f2;} #sb-wrapper-inner{border:1px solid #555;}
#sb-loading-inner span{background:url('/usr/tpl/admin/images/35-1.gif') no-repeat;padding-left:34px;
display:inline-block;}</style>";
        echo '<h2>' . $title . '</h2>';
        echo '<div class="news"><div class="pred">Краткий текст</div>' . Core::bbDecode($short, false, true) . '</div>';
        if (!empty($full)) {
            echo '<div class="news"><div class="pred">Полный текст</div>' . Core::bbDecode($full, false, true) . '</div>';
        }
    } else {
        echo 'Error! System is down. You have 10 seconds to save your data.';
    }
    echo '</div>';

    Core::tpl()->headerIncludes = array();
}