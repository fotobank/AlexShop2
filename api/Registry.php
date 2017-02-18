<?php
/*************************************************
  Framework Component
  name      AlexShop_CMS
  created   by Alex production
  version   1.0
  author    Alex Jurii <alexjurii@gmail.com>
  Copyright (c) 2016
 ************************************************/

namespace api;

use proxy\AbstractProxy;


/**
 * Основной класс AlexShop для доступа к API CMS
 *
 * @property \api\Config()     config
 * @property \api\Request()    request
 * @property \api\Database()   db
 * @property \api\Settings()   settings
 * @property \api\Design()     design
 * @property \api\Products()   products
 * @property \api\Variants()   variants
 * @property \api\Categories() categories
 * @property \api\Brands()     brands
 * @property \api\Features()   features
 * @property \api\Money()      money
 * @property \api\Pages()      pages
 * @property \api\Blog()       blog
 * @property \api\Cart()       cart
 * @property \api\Image()      image
 * @property \api\Delivery()   delivery
 * @property \api\Payment()    payment
 * @property \api\Orders()     orders
 * @property \api\Users()      users
 * @property \api\Coupons()    coupons
 * @property \api\Comments()   comments
 * @property \api\Feedbacks()  feedbacks
 * @property \api\Notify()     notify
 * @property \api\Managers()   managers
 * @property \api\Lang() languages
 * @property \api\Translations() translations
 * @property \api\Comparison() comparison
 * @property \api\Subscribes() subscribes
 * @property \api\Banners() banners
 * @property \api\Callbacks() callbacks
 * @property \api\ReportStat() reportstat
 * @property \api\Topvisor() topvisor
 */
class Registry extends AbstractProxy {

    /**
     * алиасы API
     * @var array
     */
    private static $alias = [
        'db' => 'Database',
        'languages'  => 'Lang',
        'reportstat' => 'ReportStat',
    ];
    /**
     * Созданные объекты
     * переместились в AbstractProxy
     * @var array
     */
//	private static $objects = array();


    /**
     * Registry constructor.
     */
    public function __construct() {
       //  $this->config = Config::getData('config');
	}

    /**
     * Init instance
     * @throws \exception\ComponentException
     */
    protected static function initInstance()
    {
        return new Registry();
    }


    /**
     * Магический метод, создает нужный объект API
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name) {

        // название классов можно писать с маленькой или большой букв
        $name = lcfirst ($name);
        $class = ucfirst($name);
        // Проверка алиаса в API
        if (isset(self::$alias[$name])){
            $class = self::$alias[$name];
        }
        // Если такой объект уже существует, возвращаем его
        if (isset(self::$instances[$class])){
            return self::$instances[$class];
        }

        $file_class = __DIR__ . '/' . $class . '.php';
        if(is_readable($file_class)){
            $name = "api\\$class";
        //    require_once $file_class;
            self::$instances[$class] = new $name();

        } else {
            return null;
        }

        // Возвращаем созданный объект
        return self::$instances[$class];
	}
    
    public function translit($text) {
        $ru = explode('-', 'А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я');
        $en = explode('-', 'A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch---Y-y---E-e-YU-yu-YA-ya');
        
        $res = str_replace($ru, $en, $text);
        $res = preg_replace("/[\s]+/ui", '-', $res);
        $res = preg_replace("/[^a-zA-Z0-9\.\-\_]+/ui", '', $res);
        $res = strtolower($res);
        return $res;
    }
    
    public function translit_alpha($text) {
        $ru = explode('-', 'А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я');
        $en = explode('-', 'A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch---Y-y---E-e-YU-yu-YA-ya');
        
        $res = str_replace($ru, $en, $text);
        $res = preg_replace("/[\s]+/ui", '', $res);
        $res = preg_replace("/[^a-zA-Z0-9]+/ui", '', $res);
        $res = strtolower($res);
        return $res;
    }
    
}
