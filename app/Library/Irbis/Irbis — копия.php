<?php
namespace App\Library;

Class Irbis
{
    //Выводить ответы сервера?
    private $debug = false;

    //Локальные переменные для переноса класса
    private $ip = '******', $port = '******', $sock;
    private $login = '******', $pass = '******';
    private $id = '******', $seq = 0;
    
    //Форматы возвращаемых результатов
    const ALL_FORMAT       = '&uf("+0")';  // Полные данные по полям
    const BRIEF_FORMAT     = '@brief';     // Краткое библиографическое описание
    const IBIS_FORMAT      = '@ibiskw_h';  // Формат IBIS (старый)
    const INFO_FORMAT      = '@info_w';    // Информационный формат
    const OPTIMIZED_FORMAT = '@';          // Оптимизированный формат

    //Поисковые параметры
    const KEYWORD_PREFIX    = 'K=';  // Ключевые слова
    const AUTHOR_PREFIX     = 'A=';  // Индивидуальный автор, редактор, составитель
    const COLLECTIVE_PREFIX = 'M=';  // Коллектив или мероприятие
    const TITLE_PREFIX      = 'T=';  // Заглавие
    const INVENTORY_PREFIX  = 'IN='; // Инвентарный номер, штрих-код или радиометка
    const INDEX_PREFIX      = 'I=';  // Шифр документа в базе

     /*АРМ ы
     *  АДМИНИСТРАТОР – ‘A‘
     *  КАТАЛОГИЗАТОР – ‘C’
     *  КОМПЛЕКТАТОР – ‘M’
     *  ЧИТАТЕЛЬ – ‘R’
     *  КНИГОВЫДАЧА – ‘B’
     */

    //Стандартный каталог поиска
    public $arm = 'C'; // Каталогизатор

    //Базы данных для поиска литературы
    public $DataBase = [
        '0' => 'FOND',
        '1' => 'ZNANIUM',
        '2' => 'URAIT',
        '3' => 'LAN'
    ];


    public $Server_Timeout = 30;
    public $server_ver = '';
    public $Error_Code = 0;

    function __construct() {
    }

    //Разлогирование при уничтожении экземпляра класса
    function __destruct() { $this->logout(); }

    //Коды возврата сервера
    function error($code = '')
    {
        if ($code == '') $code = $this->Error_Code;
        switch ($code) {
            case '0':
                return "Ошибки нет (Нормальное завершение)";
            case '1':
                return "Сервер не ответил";
            case '-100':
                return '-1 - заданный MFN вне пределов БД';
            case '-140':
                return 'MFN за пределами базы';
            case '-202':
                return 'Термин не существует';
            case '-203':
                return 'TERM_LAST_IN_LIST';
            case '-204':
                return 'TERM_FIRST_IN_LIST';
            case '-300':
                return 'Монопольная блокировка БД';
            case '-400':
                return 'Ошибка при открытии файла mst или xrf';
            case '-401':
                return 'Ошибка при открытии trm файлов';
            case '-402':
                return 'Ошибка при записи';
            case '-403':
                return 'Ошибка при актуализации';
            case '-600':
                return '1-запись логически удалена';
            case '-601':
                return 'Запись удалена';
            case '-602':
                return 'Запись заблокированна на ввод';
            case '-603':
                return 'Запись логически удалена';
            case '-607':
                return 'Ошибка autoin.gbl';
            case '-608':
                return 'Не совпадает номер версии у сохраняемой записи';
            case '-1111':
                return 'Ошибка выполнения сервера';
            case '-2222':
                return 'WRONG PROTOCOL';
            case '-3333':
                return 'Пользователь не существует';
            case '-3334':
                return 'Незарегестрированный пользователь не сделал ibis-reg';
            case '-3335':
                return 'Неверный уникальный идентификатор';
            case '-3336':
                return 'Нет доступа к командам АРМа';
            case '-3337':
                return 'Пользователь уже авторизован в системе';
            case '-4444':
                return 'Пароль не подходит';
            case '-5555':
                return 'Запрашиваемая база не существует';
            case '-6666':
                return 'Сервер перегружен, достигнуто максимальное число потоков обработки';
            case '-7777':
                return 'Не удалось запустить/прервать поток администратора';
        }
        return '>Неизвестный код возврата: ' . $code . '';
    }

    //Генерация поискового запроса
    function getQuery($Array) {
        if (isset($Array['submit'])) {
            (!empty($Array['bookAuthor'])) ? $author = htmlspecialchar(trim($Array['bookAuthor'])) : $author = NULL;
            (!empty($Array['bookTitle'])) ? $title = htmlspecialchar(trim($Array['bookTitle'])) : $title = NULL;
            (!empty($Array['bookKeyWord'])) ? $wordKey = htmlspecialchar(trim($Array['bookKeyWord'])) : $wordKey = NULL;
        }
        $query = '';
        //Собираем поисковый запрос
        if ($author) {
            $author = serachInLine($author,'A=');
            $query = $author;
        }
        if ($title) {
            $title = serachInLine($title,'T=');
            (empty($query)) ? $query = $title : $query = $query.' * '.$title;
        }
        if ($wordKey) {
            $wordKey = serachInLine($wordKey,'K=');
            (empty($query)) ? $query = $wordKey : $query = $query.' * '.$wordKey;
        }
        return $query;
    }

    //Разбивка параметра на составляющие
    function serachInLine($line,$type) {
        //Определяем кооличество полученных авторов
        $lines = explode(',', $line);
        $line = '(';
        if (count($lines) > 0) {
            for ($i = 0; $i < (count($lines)-1); $i++) {
                $line = $line.'"'.$type.$lines[$i].'$" + ';
            }
            $line = $line.'"'.$type.$line[(count($lines)-1)].'$")';
        }
        return $line;
    }

    //Подключение к серверу библиотеки
    function connect()
    {
        if ($this->debug) echo 'Подключение к серверу библиотеки: \n';
        $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->sock === false) {
            if ($this->debug) echo 'Произошла ошибка при создании сокета! \n';
            return false;
        } else {
            if ($this->debug) echo 'Сокет соединения успешно создан! \n';
        }
        if (@socket_connect($this->sock, $this->ip, $this->port)) {
            if ($this->debug) echo 'Соединение с сервером успешно установленно! \n';
            return true;
        } else {
            if ($this->debug) echo 'Произошла ошибка при соединении с сервером! \n';
            return false;
        }
    }

    //Подтверждение авторизации
    function loginVerification()
    {
        if ($this->debug) echo 'Выполняется попытка авторизации \n';
        //Формируем отправляемый пакет
        $Packet = implode("\n", array('N', $this->arm, 'N', $this->id, $this->seq, '','','','',''));
        $Packet = strlen($Packet) . "\n" . $Packet;
        //Отправляем пакет на сервер
        $Answer = $this->sendPacket($Packet);
        if ($Answer[10] == 0) {
            if ($this->debug) echo 'Подтверждение авторизации прошло успешно! \n';
            return true;
        } else {
            if ($this->debug) echo 'Произошла ошибка при подтвержении регистрации. \n';
            $this->error_code = $Answer[10];
            if ($this->debug) print_r($Answer);
            return false;
        }
    }

    //Авторизация
    function login()
    {
        if ($this->debug) echo 'Выполняется попытка авторизации \n';
        //Формируем отправляемый пакет
        $Packet = implode("\n", array('A', $this->arm, 'A', $this->id, $this->seq, '', '', '', '', '', $this->login, $this->pass));
        $Packet = strlen($Packet) . "\n" . $Packet;
        //Отправляем пакет на сервер
        $Answer = $this->sendPacket($Packet);
        //Если подключение не удалось, выводим ошибки
        if (($Answer === false)) {
            $this->Error_Code = 1;
            if ($this->debug) echo 'Произошла ошибка при попытке авторизации \n';
            if ($Answer === false)  if ($this->debug) echo 'Ответ от сервера не получен! \n';
            else  if ($this->debug) echo 'Сервер вернул пустой ответ! \n';
            return false;
        }
        //Если обнаружн код ошибки, выводим его на экран
        if (!empty($Answer[10])) {
            $this->Error_Code = $Answer[10];
        }
        if ($this->Error_Code != 0) return false;
        $this->server_timeout = $Answer[11];
        $this->server_ver = $Answer[4];
        if ($this->debug) echo 'Авторизация прошла успешно! \n';
        return true;
    }

    // Завершение сессии
    function logout()
    {
        if ($this->debug) echo 'Выход из системы \n';
        //Формируем отправляемый пакет
        $Packet = implode("\n", array('B', $this->arm, 'B', $this->id, $this->seq, '', '', '', '', '', $this->login));
        $Packet = strlen($Packet) . "\n" . $Packet;
        //Отправляем пакет на сервер
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) {
            if ($this->debug) echo 'Не получен ответ сервера при выходе из системы \n';
            return false;
        }
        if (isset ($Answer[10])) {
            $this->Error_Code = $Answer[10];
            if ($this->Error_Code != 0) {
                if ($this->debug) echo 'Получен код ошибки при выходе из системы \n';
                return false;
            }
        }
        if ($this->debug) echo 'Вывод из системы успешно выполнен \n';
        return true;
    }

    // Поиск записей по запросу
    function recordsSearch($Query, $num_records = 1, $first_record = 0, $format = '@', $min = null, $max = null, $expression = null)
    {
        if ($this->debug) echo 'Выполняется попытка поиска записей \n';
        if ($this->debug) echo 'Начался поиск записей по запросу: '.$Query.PHP_EOL.' \n';
        if ($expression != '')  if ($this->debug) echo 'C уточняющими условиями '.$expression.PHP_EOL.' \n';
        //Отмечает время начало поиска
        $timeStart = (float)microtime();
        $searchNumber = 0;
        for ($i=0; $i<4; $i++) {
            //Формируем поисковый пакет для каждой базы данных
            $Packet = implode("\n", array('K',  $this->arm, 'K', $this->id, $this->seq++, $this->pass, $this->login, '', '', '', $this->DataBase[$i], $Query, 10000, $first_record, $format));
            $Packet = strlen($Packet) . "\n" . $Packet;
            //Отправляем пакет на сервер
            $Answer = $this->sendPacket($Packet);
            if ($Answer === false) {
                if ($this->debug) echo 'Не получен ответ от сервера выполнении поиска записей \n';
                return false;
            }
            if ($Answer[10] != 0) {
                $this->Error_Code = $Answer[10];
                $result[$this->DataBase[$i]]['error_code'] = $this->Error_Code;
                if ($this->debug) echo 'Получен код ошибки при выполнении поиска \n';
                return $result;
            }
            if (!empty($Answer[11])) {
                if (!empty($Answer[11]))  if ($this->debug) echo 'Количество найденных записей = ' . $Answer[11] . ' \n';
                $searchNumber += $Answer[11]; // количество найденных записей
            } else {
                if ($this->debug) echo 'Записи по запросу небыли найденны  \n';
            }
            $c = count($Answer) - 1;
            for ($j = 11; $j < $c; $j++) {
                $result[$this->DataBase[$i]]['records'][] = $Answer[$j];
            }
        }
        $result['searchNumber'] = $searchNumber;
        //Замеряем время завершения поиска
        $searchTime = (float)microtime() - $timeStart;
        $searchTime = substr($searchTime,0,-3);
        $result['searchTime'] = $searchTime*10;
        $result['error_code'] = $this->Error_Code;
        return $result;
    }

    //Отправка пакета на сервер
    function sendPacket($Packet)
    {
        if ($this->debug) echo 'Отправка пакета на сервер. \n';
        if ($this->sock === false) {
            if ($this->debug)  echo 'Произошла ошибка при содании сокета! \n';
            return false;
        } else {
            if ($this->debug) echo 'Сокет соединения успешно создан! \n';
        }
        if ($this->connect()) {
            if ($this->debug)  echo 'Соединение к сервером библиотеки для отправки пакета открыто! \n';
        } else {
            if ($this->debug) echo 'Ошибка при соединении с сервером во время попытки отправить пакет! \n';
            return false;
        }
        $this->seq++;
        if ($this->debug) echo 'Отправленный на сервер пакет: ' . $Packet . PHP_EOL . ' \n';
        if (socket_write($this->sock, $Packet, strlen($Packet))) {
            if ($this->debug)  echo 'Пакет ---><b>'.$Packet.'</b><--- был отправлен на сервер \n';
        } else {
            if ($this->debug)  echo 'Отправка пакета на сервер не удалась! \n';
        }
        $Answer = '';
        if ($this->debug) echo 'Ожидание ответа от сервера \n';
        while ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
                $Answer .= $buf;
                $get_answer = 1;
        }
        if ($this->debug)  print_r($Answer);
        if ($get_answer == 1) {
            if ($this->debug)  echo 'Получен ответ от сервера \n';
            $result['code'] = $Answer[10];
        } else {
            if ($this->debug)  echo 'Сервер не ответил на отправленный пакет! \n';
        }

        if ($this->debug) echo 'Полученный ответ от сервера: \n';
        if ($this->debug) print_r($Answer);
        socket_close($this->sock);
        if ($this->debug) echo 'Сокет соединения закрыт \n';
        if (!$get_answer) {
            if ($this->debug) echo  'С сервера поступил пустой ответ! \n';
        }
        return explode("\r\n", $Answer);
    }

// Раскодировать строку поля на ассоциированный массив с подполями
    function parse_field(&$field)
    {
        $ret = array();
        $matches = explode('^', $field);
        if (count($matches) == 1) {
            $matches = explode("\x1f", $field);
        }
        foreach ($matches as $match) {
            $ret[(string)substr($match, 0, 1)] = substr($match, 1);
        }
        return $ret;
    }

// Раскодировать бинарную строку
    function blob_decode($blob)
    {
        return preg_replace_callback('/%([A-Fa-f0-9]{2})/', function ($matches) {
            return pack('H2', $matches[1]);
        }, $blob);
    }
}
?>
