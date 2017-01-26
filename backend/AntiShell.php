<?php
/**
 * =============================================================================
 * AntiShell - Скрипт для котроля за изменениями в файлах на сайте.
 * =============================================================================
 * Автор кода основных методов: Sander
 * URL: http://sandev.pro/
 * ICQ: 404-037-556
 * email: olalod@mail.ru
 * -----------------------------------------------------------------------------
 * Идея, доработка внешнего вида, переработка кода и документирование: ПафНутиЙ
 * URL: http://pafnuty.name/
 * ICQ: 817233
 * email: pafnuty10@gmail.com
 * =============================================================================
 * Версия: 1.2.2 от 20.01.2015
 * =============================================================================
 */

use api\Registry;
use proxy\Config;

require_once(__DIR__ . '/../system/configs/define/config.php');
/** @noinspection PhpIncludeInspection */
require_once SYS_DIR . 'core' . DS . 'boot.php';

/**
 * Class AntiShell
 * Команды для выполнения через cron (Скопируйте одну и вставьте в планировщик):
 * Через wget: /usr/bin/wget -O - -q "http://anti/backend/AntiShell.php"
 * Через php: /usr/bin/php -f O:/domains/Anti/backend/AntiShell.php
 * ручной запуск: /backend/AntiShell.php?snap=y
 * Путь к php или wget у вас может отличаться! Проверьте корректность пути (можно уточнить в ТП хостинга).
 * Рекомендую ставить в планировщик минимум раз в сутки (лучше раз в час).
 * Если ресурсы хостинга позволяют - раз в час.
 * Так вы отловите зловредный код или просто изменения в файлах очеь быстро.
 */
class AntiShell extends Registry
{

    /**
     * Версия скрипта
     * @var string
     */
    public $version = '1.21';

    /**
     * Массив с конфигурацией скрипта
     * @var array
     */
    public $conf;

    /**
     * Засечка времени для статистики
     * @var string
     */
    public $timeStart;

    /**
     * Полное имя файла снимка
     * @var string
     */
    public $snapFile;

    /**
     * Учитываем чистые затраты памяти
     * @var int|string
     */
    public $memoryStart;

    /**
     * Конструктор класса

     */
    public function __construct()
    {
        parent::__construct();
        $this->timeStart = $this->timer();
        $this->memoryStart = $this->getMemory();
        $this->conf = Config::getData('antivirus');
        $this->conf['makesnap'] = (isset($_GET['snap']) && trim($_GET['snap']) == 'y');
    }

    /**
     * Подсчитываем время выполнения скрипта
     *
     * @param bool|string $stop
     *
     * @return float|mixed
     */
    public function timer($stop = false)
    {
        return ($stop) ? (microtime(true) - $stop) : microtime(true);
    }

    /**
     * Подсчитываем затраты памяти
     *
     * @param bool|string $stop
     *
     * @return int|string
     */
    public function getMemory($stop = false)
    {
        if (function_exists('memory_get_usage')){
            return ($stop) ? (memory_get_usage() - $stop) : memory_get_usage();
        }
        return 0;
    }

    /**
     * Устанавливаем конфиг
     *
     * @param array $arConfig
     *
     * @return $this
     */
    public function setConfig(array $arConfig = [])
    {
        $this->conf = $arConfig;

        return $this;
    }

    /**
     * Основной метод класса
     */
    public function run()
    {
        // Определяем файл снимка
        $this->snapFile = $this->setDirSep($this->config->root_dir . $this->conf['scanfile']);

        // Преобразуем нужные строки конфига в массив для дальнейшей работы.
        $this->conf['ext'] = $this->str2array($this->conf['ext']);
        $this->conf['skipfile'] = $this->str2array($this->conf['skipfile'] . ',' . basename($this->snapFile));
        $this->conf['skipdir'] = $this->setDirSep($this->str2array($this->conf['skipdir']));

        // Запускаем сканирование
        $scan = $this->doScan($this->config->root_dir . $this->conf['path']);
        // Пишем в файл
        $makeFile = $this->makeFile($scan);

        // Определяем выводимый контент и заголовок письма
        $status = $makeFile['status'];
        $allowMail = false;
        $title = '';
        // Разные статусы сканирования
        switch ($status) {
            case '1':
                $title = 'На сайте изменены файлы.';
                $allowMail = true;
                break;

            case '2':
                $title = 'Файлы не менялись.';
                $allowMail = false;
                break;

            case '3':
                $title = 'Файл снимка успешно создан.';
                $allowMail = true;
                break;

            case '4':
                $title = 'Ошибка при создании файла со снимком.';
                $allowMail = true;
                break;
        }

        // Определяем, что будет в контенте
        $content = $makeFile['text'] . $this->showStat();

        // Суём контент в шаблон для вывода
        $output = $this->template($this->conf['sitename'], str_replace($this->config->root_dir, '', $content));

        // Отправляем уведомление на почту.
        if ($allowMail){
            $mailArr = $this->str2array($this->conf['email']);
            foreach ($mailArr as $mail){
                $this->mailFromSite($output, $mail, $title);
            }
        }
        // Выводим результаты в браузер
        if ($this->conf['showtext']){
            $this->showOutput($output, $this->conf['charset']);
        }
    }

    /**
     * @param $path
     *
     * @return mixed
     */
    protected function setDirSep($path)
    {
        return str_replace(['\\', '/'], DS, $path);
    }

    /**
     * Преобразуем строку в массив
     * @author Sander http://sandev.pro/
     *
     * @param        $array     - входящая строка
     * @param string $delimiter - разделитель массива
     *
     * @return array|bool
     */

    public function str2array($array, $delimiter = ',')
    {
        if (!$array or $array == '*'){
            return false;
        }
        $arOld = explode($delimiter, $array);
        $arNew = [];
        foreach ($arOld as $v){
            $v = trim($v);
            if ($v){
                $arNew[] = $v;
            }
        }

        return $arNew;
    }

    /**
     * @param string $dir    - Путь к сканируемой папке
     * @param string $subdir - подпапка
     *
     * @return array
     */
    public function doScan($dir, $subdir = '')
    {
        $arFilesInfo = [];
        $scandir = $dir . $subdir;

        $directory = new RecursiveDirectoryIterator($scandir, RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($iterator as $obFile){

            $fileName = $obFile->getFilename();
            $fileSize = $obFile->getSize();
            $pathName = $obFile->getPathname();
            $fileExtension = $obFile->getExtension();

            if (!empty($this->conf['skipdir']) && $this->strposa($pathName, $this->conf['skipdir'])){
                continue;
            }
            if (!empty($this->conf['skipfile']) && (in_array($fileExtension, $this->conf['skipfile']) || in_array($fileName, $this->conf['skipfile']))){
                continue;
            }

            $fileCTime = $obFile->getCTime();
            $hash = md5($pathName . $fileName . $fileSize . $fileCTime);
            //$arFilesInfo[$hash]['hash'] = $hash;
            $arFilesInfo[$hash]['path'] = $pathName;
            $arFilesInfo[$hash]['date'] = $fileCTime;

        }

        return $arFilesInfo;
    }

    /**
     * Метод для реализации strpos с массивом
     *
     * @param string $haystack - Где искать
     * @param array  $needle   - Что искать (массив)
     * @param int    $offset   - Если этот параметр указан, то поиск будет начат с указанного количества символов с
     *                         начала строки. {@see strpos()}
     *
     * @return bool
     */
    public function strposa($haystack, $needle, $offset = 0)
    {
        if (!is_array($needle)){
            $needle = [$needle];
        }
        foreach ($needle as $query){
            if (strpos($haystack, $query, $offset) !== false){
                return true;
            } // stop on first true result
        }

        return false;
    }

    /**
     * Метод, создающий файл снимка
     *
     * @param $arScan - массив с результатами из метода doScan
     *
     * @return array  - возвращает статус процесса и текст результата
     */
    public function makeFile($arScan)
    {
        $makeFileInfo = [];
        $edit = [];
        $changedCount = 0;
        $addedCount = 0;
        $deletedCount = 0;
        $totalFilesCount = count($arScan);
        $tf_text = $this->declination($totalFilesCount, 'фай|л|ла|лов');

        if (is_readable($this->snapFile)){
            $strScanFile = file_get_contents($this->snapFile);
            $arScanFile = unserialize($strScanFile, ['allowed_classes' => true]);
            $strScan = serialize($arScan);

            $diff = array_diff_key($arScan, $arScanFile);

            foreach ($diff as $hash => $arFile){
                $fPath = $arFile['path'];
                $fDate = date("Y-m-d H:i:s", $arFile['date']);
                if (strpos($strScanFile, $fPath) !== false){
                    $edit[$hash] = $this->listStyler('change', $fDate, $fPath);
                    $changedCount++;
                } else {
                    $edit[$hash] = $this->listStyler('add', $fDate, $fPath);
                    $addedCount++;
                }
            }

            $deletedDiff = array_diff_key($arScanFile, $arScan);

            foreach ($deletedDiff as $hash => $arFile){
                $fPath = $arFile['path'];
                $fDate = date("Y-m-d H:i:s", $arFile['date']);
                if (strpos($strScan, $fPath) === false){
                    $edit[$hash] = $this->listStyler('del', $fDate, $fPath);
                    $deletedCount++;
                }
            }

            unset($diff, $deletedDiff);
            if ($edit){
                arsort($edit);
                $snapDate = date("j.m.Y в H:i:s", filemtime($this->snapFile));
                $logs = implode("\n\t", $edit);
                $changeText = $this->declination($changedCount, 'фай|л изменён|ла изменено|лов изменено');
                $addText = $this->declination($addedCount, 'фай|л добавлен|ла добавлено|лов добавлено');
                $delText = $this->declination($deletedCount, 'фай|л удалён|ла удалены|лов удалено');
                $snapInfo = ($this->conf['makesnap'] || $this->conf['allowsnap']) ? "<p>Снимок создан <b>{$snapDate}</b></p>" : "<p>Дата сканирования: <b>{$snapDate}</b></p>";

                $makeFileInfo['status'] = '1';
                $makeFileInfo['text'] = "<h1 style=\"font:normal 22px 'Trebuchet MS',Arial,sans-serif;color:#2980b9;padding:40px 10px 10px;text-align: center;\">{$this->conf['sitename']} - Сканирование завершено</h1>
				<ul style='list-style:none;margin:0 0 15px 0;padding:0;'>
					{$logs}
				</ul>
				<div style='color: #34495e; line-height: 22px !important; margin-left: 40px;'>
					{$snapInfo}
					<p>
						Всего отсканировано <b>{$totalFilesCount}</b> {$tf_text}, из них:
						<br>- <b>{$changedCount}</b> {$changeText}
						<br>- <b>{$addedCount}</b> {$addText}
						<br>- <b>{$deletedCount}</b> {$delText}
					</p>
					<p>Запущено с IP: <b>{$_SERVER['REMOTE_ADDR']}</b></p>
				</div>";
            } else {

                $makeFileInfo['status'] = '2';
                $makeFileInfo['text'] = "<h1 style=\"font:normal 22px 'Trebuchet MS',Arial,sans-serif;color:#16a085;padding:40px 10px 10px;text-align: center;\">Файлы не менялись. Всё ок!</h1>";
            }

        } else {

            file_put_contents($this->snapFile, serialize($arScan), LOCK_EX);
            if (file_exists($this->snapFile)){
                $makeFileInfo['status'] = '3';
                $makeFileInfo['text'] = "<h1 style=\"font:normal 22px 'Trebuchet MS',Arial,sans-serif;color:#16a085;padding:40px 10px 10px;text-align: center;\">{$this->conf['sitename']} - Файл снимка успешно создан " . date("Y-m-d в H:i:s") . "</h1> <p style='color: #34495e; line-height: 22px !important; margin-left: 40px; '>В снимке содержится: <b>{$totalFilesCount}</b> {$tf_text}</p>";
            } else {

                $makeFileInfo['status'] = '4';
                $makeFileInfo['text'] = "<h1 style=\"font:normal 22px 'Trebuchet MS',Arial,sans-serif;color:#c0392b;padding:40px 10px 10px;text-align: center;\">{$this->conf['sitename']} - Файл снимка не создан!</h1>
					<div style='color: #34495e; line-height: 22px !important; margin-left: 40px;'>
						Возможные причины:
						<br />- <b>Не хватает прав.</b> Установите на папку, содержащую снимок права на запись (CHMOD 755 или 777).
						<br />- <b>Неверный путь к корню сайта.</b> Откройте файл скрипта и отредактируйте настройки в ручную, либо запустите устаовку ещё раз.
						<br />- <b>Особенности хостинга или распределения прав пользователей.</b> Обратитесь за помошью в службу технической поддержки хостинга или на сайт <a href='http://antishell.ru/' target='_blank'>antishell.ru</a> (будьте готовы дать FTP-доступ к папке со скриптом и папке со снимком)
					</div>";

            }
        }

        return $makeFileInfo;
    }

    /**
     * Функция для установки правильного окончания слов
     *
     * @param int    $n     - число, для которого будет расчитано окончание
     * @param string $words - варианты окончаний для (1 комментарий, 2 комментария, 100 комментариев)
     *
     * @return string - слово с правильным окончанием
     */
    public function declination($n = 0, $words)
    {
        $words = explode('|', $words);
        $n = (int)$n;

        return $n % 10 == 1 && $n % 100 != 11 ? $words[0] . $words[1] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $words[0] . $words[2] : $words[0] . $words[3]);
    }

    /**
     * @param string $class - название CSS-класса
     * @param string $time  - время
     * @param string $file  - адрес файла
     *
     * @return string
     */
    public function listStyler($class = 'change', $time, $file)
    {
        $icon_url = $this->conf['icon_url'];
        $liInfo = $this->liInfo('#7f8c8d');

        switch ($class) {
            case 'add':
                $liInfo = $this->liInfo('#16a085', 'Добавлен файл', 'no-repeat 10px 3px');
                break;

            case 'del':
                $liInfo = $this->liInfo('#7f8c8d', 'Удален файл', 'no-repeat 10px -53px');
                break;

            case 'change':
                $liInfo = $this->liInfo('#c0392b', 'Изменен файл', 'no-repeat 10px -25px');
                break;
        }

        $def_style = 'display:block;line-height:24px;font-family:Arial,sans-serif;padding:2px 10px;margin:0;border-bottom:1px solid #bdc3c7;font-size:14px;color:#7f8c8d;';

        $span_style = 'display:block;height:24px;float:left;padding-right:10px;padding-left:40px;margin-right:10px;border-right:1px solid #bdc3c7;font-size:12px;background: url(' . $icon_url . ') ' . $liInfo['bgPosition'] . ';';

        $li = '<li style="' . $def_style . '" title="' . $liInfo['liTooltip'] . '"><span style="' . $span_style . '">' . $time . '</span> <span style="color:' . $liInfo['color'] . ';overflow:hidden;display:block;word-wrap:break-word;">' . $file . '</span></li>';

        return $li;
    }

    /**
     * @param string $color
     * @param string $liTooltip
     * @param string $bgPosition
     *
     * @return array
     */
    private function liInfo($color = '', $liTooltip = '', $bgPosition = '')
    {
        return ['color' => $color, 'liTooltip' => $liTooltip, 'bgPosition' => $bgPosition];
    }

    /**
     * Показываем статистику
     * @return string
     */
    public function showStat()
    {
        $timerStart = $this->timeStart;
        $time = round($this->timer($timerStart), 5);
        $memory = (!function_exists('memory_get_peak_usage')) ? 'неизвестно' : round(memory_get_peak_usage() / 1024 / 1024, 2) . ' Mb';
        $realMemory = round($this->getMemory($this->memoryStart) / 1024 / 1024, 3) . ' Mb';
        $showSendStatInfo = '';

        $stat = '<div style="color: #34495e; line-height: 22px !important; margin-left: 40px; margin-top: 10px; border-top: 1px solid #bdc3c7;">
			<p>Время выполнения: ' . $time . ' Сек.
			<br />Затраты памяти <small>(максимальное потребление)</small>: ' . $memory . '
			<br />Затраты памяти <small>(реальное потребление)</small>: ' . $realMemory . '</p>
			' . $showSendStatInfo . '
		</div>';

        return $stat;
    }

    /**
     * Шаблон для вывода в браузер и отправку уведомления на email
     *
     * @param string $title   - заголовок окна браузера
     * @param string $content - выводимый контент
     *
     * @return string
     */
    public function template($title = '', $content = '')
    {
        $template = <<<HTML
<!DOCTYPE html>
<html>
	<head>
		<meta charset="{$this->conf['charset']}" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>{$title}</title>
	</head>
	<body style="background-color:#ecf0f1; max-width: 800px; margin: 0 auto;padding:0;">
		<div  style="background-color:#ecf0f1;font:normal 16px 'Trebuchet MS',Arial,sans-serif;color:#7f8c8d;margin:0;padding:5px 5px 35px 5px;">
			{$content}
		</div>
	</body>
</html>
HTML;

        return $template;
    }

    /**
     * @param string $content - контент сообщения
     * @param string $email   - email получателя
     * @param string $title   - тема сообщения
     *
     * @return bool
     */
    public function mailFromSite($content, $email, $title = 'На сайте изменены файлы')
    {
        // имя отправителя (берётся из имени сайта)
        $subject = $this->conf['sitename'];
        // email отправителя
        $from_email = $this->str2array($this->conf['from_email'])[0];
        $set_mail = (trim($from_email) != '') ? $from_email : $email;

        if (trim($subject) != ''){
            $from = $this->mimeEncode($subject, $this->conf['charset']) . ' <' . $set_mail . '>';
        } else {
            $from = '<' . $set_mail . '>';
        }

        $content = str_replace("\r", "", $content);
        $headers = 'From: ' . $from . "\r\n";
        $headers .= "X-Mailer: ANTI-SHELL\r\n";
        $headers .= 'Content-Type: text/html; charset=' . $this->conf['charset'] . "\r\n";
        $headers .= "Content-Transfer-Encoding: 8bit\r\n";
        $headers .= 'X-Priority: 1 (Highest)';

        $mail_send = mail($email, $this->mimeEncode($title, $this->conf['charset']), $content, $headers);

        return $mail_send;
    }

    /**
     * Преобразование кодировки в кодировку )))
     *
     * @param string $text
     * @param        $charset
     *
     * @return string
     */
    public function mimeEncode($text, $charset = "utf-8")
    {
        return '=?' . $charset . '?B?' . base64_encode($text) . '?=';
    }

    /**
     * @param $output  - что выводим
     * @param $charset - кодировка, отдаваемая браузеру
     */
    public function showOutput($output, $charset)
    {
        $this->showHeader($charset);
        echo $output;
    }

    /**
     * @param string $charset
     */
    public function showHeader($charset = 'utf-8')
    {
        header('Content-type: text/html; charset=' . $charset);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->conf;
    }

}

if (Config::getData('antivirus')['on']){
    $scan = new AntiShell();
    $scan->run();
}