<?php
/**
 * Класс Registry
 * @created   by PhpStorm
 * @package   Reg.php
 * @version   1.0
 * @author    Alex Jurii <jurii@mail.ru>
 * @link      http://alex.od.ua
 * @copyright Авторские права (C) 2000-2015, Alex Jurii
 * @date:     13.07.2015
 * @time:     23:11
 * @license   MIT License: http://opensource.org/licenses/MIT
 */

namespace lib\helper\Pattern;

use exception\BaseException;


/**
 * Class RegException
 * @package lib\pattern
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class RegistryException extends BaseException
{
}

/**
 * //создать экземпляр класса db(если он уже существует, то перезаписать) и вызвать функцию action<br>
 * Registry::build('db')->action();
 *
 * удалить экземпляр класса db
 * Registry::del('db');
 *
 * обратиться к экземпляру класса db(если он не существует, то создать) и вызвать функцию action
 * можно обращаться из любого места в приложении, вызываться будет один и тот же экземпляр
 * Registry::call('db')->action();
 *
 * аналогично предыдущему, но с одной разницей: экземпляр класса db будет записан в переменную $vars с индексом db:site
 * можно создавать сколь угодно много экземпляров одного и того же класса с разными индексами
 * Registry::call('db:site')->action();
 *
 * удалить экземпляр класса db с индексом site
 * Registry::del('db:site');
 *
 * и еще пара примеров:
 * Registry::build('db:site')->connect($login,$pass,$host);
 * Registry::build('db:forum')->connect($login2,$pass2,$host2);
 *
 * $row1 = Registry::call('db:site')->query("query to site database...");
 * $row2 = Registry::call('db:forum')->query("query to forum database...");
 *
 * Registry::call('tpl:style1')->setStyle('style2');
 *
 * $template1 = Registry::call('tpl:style1')->load('index')->compile(); //получить шаблон index из стиля style1
 * $template2 = Registry::call('tpl:style2')->load('index')->compile(); //получить шаблон index из стиля style2
 *
 * Class Registry
 * @package lib\pattern
 */

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class Registry
{

    private static $vars = [];

    /**
     * @param $id
     * @param bool $data
     * @return mixed
     * @throws RegistryException
     */
    public static function build($id, $data = false)
    {
        try {
            //создание класса
            list($class,) = explode(':', $id);
            $id_var = str_replace('\\', ':' , $id);
            self::$vars[$id_var] = new $class($data);
            return self::$vars[$id_var];
        } catch (RegistryException $e) {
            throw new RegistryException($e);
        }
    }

    /**
     * @param $id
     * @param bool $data
     * @return mixed
     * @throws RegistryException
     */
    public static function call($id, $data = false)
    {
        try {
            $id_var = str_replace('\\', ':' , $id);
            //вызов класса(при отсутствии готового экземпляра - создание нового и вызов)
            if(!array_key_exists($id_var, self::$vars)) {
                return self::build($id, $data);
            } else {
                return self::$vars[$id_var];
            }
        } catch (RegistryException $e) {
            throw new RegistryException($e);
        }
    }


    /**
     * @param $id
     * @return bool
     * @throws RegistryException
     */
    public static function del($id)
    {
        try {
            //удаление значения(любого типа, в т.ч. класса)
            if(array_key_exists($id, self::$vars)) {
                unset(self::$vars[$id]);
            }
            return true;
        } catch (RegistryException $e) {
            throw new RegistryException($e);
        }
    }
}