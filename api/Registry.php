<?php
use proxy\Config;


/**
 * Основной класс AlexShop для доступа к API CMS
 *
 * @property Config()     config
 * @property Request()    request
 * @property Database()   db
 * @property Settings()   settings
 * @property Design()     design
 * @property Products()   products
 * @property Variants()   variants
 * @property Categories() categories
 * @property Brands()     brands
 * @property Features()   features
 * @property Money()      money
 * @property Pages()      pages
 * @property Blog()       blog
 * @property Cart()       cart
 * @property Image()      image
 * @property Delivery()   delivery
 * @property Payment()    payment
 * @property Orders()     orders
 * @property Users()      users
 * @property Coupons()    coupons
 * @property Comments()   comments
 * @property Feedbacks()  feedbacks
 * @property Notify()     notify
 * @property Managers()   managers
 * @property Lang() languages
 * @property Translations() translations
 * @property Comparison() comparison
 * @property Subscribes() subscribes
 * @property Banners() banners
 * @property Callbacks() callbacks
 * @property ReportStat() reportstat
 * @property Topvisor() topvisor
 */
class Registry {

    /**
     * алиасы API
     * @var array
     */
    private $alias = [
        'db' => 'Database',
        'languages'  => 'Lang',
    ];
    /**
     * Созданные объекты
     * @var array
     */
	private static $objects = array();


    /**
     * Registry constructor.
     */
    public function __construct() {
       //  $this->config = Config::getData('config');
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
        if (isset($this->alias[$name])){
            $class = $this->alias[$name];
        }
        // Если такой объект уже существует, возвращаем его
        if (isset(self::$objects[$class])){
            return self::$objects[$class];
        }

        $file_class = __DIR__ . '/' . $class . '.php';
        if(is_readable($file_class)){
         //   require_once $file_class;
            self::$objects[$class] = new $class();

        } else {
            return null;
        }

        // Возвращаем созданный объект
        return self::$objects[$class];
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