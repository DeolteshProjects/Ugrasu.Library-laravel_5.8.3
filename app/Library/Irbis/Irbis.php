<?php
namespace App\Library;

Class Irbis
{
    //Выводить ответы сервера?
    private $debug = false;

    //Локальные переменные для переноса класса
    private $ip = '192.168.6.30', $port = '6666', $sock;
    private $login = '1', $pass = '11';
    private $id = '554289', $seq = 0;

    /*АРМ ы
     *  АДМИНИСТРАТОР – ‘A‘
     *  КАТАЛОГИЗАТОР – ‘C’
     * КОМПЛЕКТАТОР – ‘M’
     * ЧИТАТЕЛЬ – ‘R’
     * КНИГОВЫДАЧА – ‘B’
     */

    // Распространённые форматы

    const ALL_FORMAT       = "&uf('+0')";  // Полные данные по полям
    const BRIEF_FORMAT     = '@brief';     // Краткое библиографическое описание
    const IBIS_FORMAT      = '@ibiskw_h';  // Формат IBIS (старый)
    const INFO_FORMAT      = '@info_w';    // Информационный формат
    const OPTIMIZED_FORMAT = '@';          // Оптимизированный формат

    // Распространённые поиски

    const KEYWORD_PREFIX    = 'K=';  // Ключевые слова
    const AUTHOR_PREFIX     = 'A=';  // Индивидуальный автор, редактор, составитель
    const COLLECTIVE_PREFIX = 'M=';  // Коллектив или мероприятие
    const TITLE_PREFIX      = 'T=';  // Заглавие
    const INVENTORY_PREFIX  = 'IN='; // Инвентарный номер, штрих-код или радиометка
    const INDEX_PREFIX      = 'I=';  // Шифр документа в базе

    public $arm = 'C'; // Каталогизатор
    public $DataBase = [
        '0' => 'FOND',
        '1' => 'ZNANIUM',
        '2' => 'URAIT',
        '3' => 'LAN'
    ]; //
    public $Server_Timeout = 30;
    public $server_ver = '';
    public $Error_Code = 0;

    function __construct() {}

    //Разлогирование при уничтожении класса
    function __destruct() { $this->logout(); }

    //Методы замены входных параметров
    function set_server($ip, $port = '6666')
    {
        $this->ip = $ip;
        $this->port = (int)$port;
    }

    function set_user($login, $pass)
    {
        $this->login = $login;
        $this->pass = $pass;
    }

    function set_arm($arm)
    {
        $this->arm = $arm;
    }

    function set_db($DataBase)
    {
        $this->DataBase = $DataBase;
    }

    function set_id($id)
    {
        $this->id = $id;
    }

//Коды возврата сервера
    function error($code = '')
    {
        if ($code == '') $code = $this->Error_Code;

        switch ($code) {
            case '0':
                return "<div class='alert alert-success'>Ошибки нет (Нормальное завершение)</div>";
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

//Собираем строку поискового запроса
    function getQuery($Array) {
        if (isset($Array["submit"])) {
            (!empty($Array["bookAuthor"])) ? $Author = $Array['bookAuthor'] : $Author = null;
            (!empty($Array["bookTitle"])) ? $Title = $Array['bookTitle'] : $Title = null;
            (!empty($Array["bookKeyWord"])) ? $WordKey = $Array['bookKeyWord'] : $WordKey = null;
            (!empty($Array["bookLimit"])) ? $Limit = $Array['bookLimit'] : $Limit = 1;
        }
        //Совляем запрос
        $Query = "";
        if (!empty($Author)) {
            $Query = $Query . '("A='.$Author.'$")';
        }
        if (!empty($Title)) {
            if (!empty($Query)) {
                $Query = $Query.' * ("T='.$Title.'$")';
            } else {
                $Query = $Query.'("T='.$Title.'$")';
            }
        }
        if (!empty($WordKey)) {
            if (!empty($Query)) {
                $Query = $Query.' * ("K='.$WordKey.'$")';
            } else {
                $Query = $Query.'("K='.$WordKey.'$")';
            }
        }
        if ($this->debug) echo "<div class='alert alert-info'>Итоговый поисковый запрос: ".$Query."</div>";
        return $Query;
    }

//Подключение к серверу
    function connect()
    {
        if ($this->debug) echo "<div class='alert alert-primary'>";
        if ($this->debug) echo "<div class='alert alert-heading'>Подключение к серверу библиотеки:</div>";
        $this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->sock === false) {
            if ($this->debug) echo "<div class='alert alert-danger'>Произошла ошибка при содании сокета!</div></div>";
            return false;
        } else {
            if ($this->debug) echo "<div class='alert alert-success'>Сокет соединения успешно создан!</div>";
        }
        if (@socket_connect($this->sock, $this->ip, $this->port)) {
            if ($this->debug) echo "<div class='alert alert-success'>Соединение с сервером успешно установленно!</div></div>";
            return true;
        } else {
            if ($this->debug) echo "<div class='alert alert-danger'>Произошла ошибка при соединении с сервером!</div></div>";
            return false;
        }
    }

//Подтверждение авторизации
    function loginVerification()
    {
        if ($this->debug) echo "<div class='alert alert-info'><div class='alert alert-heading'>Выполняется попытка авторизации</div>";
        if ($this->debug) echo "</div>";
        $Packet = implode("\n", array('N', $this->arm, 'N', $this->id, $this->seq, '','','','',''));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer[10] == 0) {
            if ($this->debug) echo "<div class='alert alert-success'>Подтверждение авторизации прошло успешно!</div>";
            return true;
        } else {
            if ($this->debug) echo "<div class='alert alert-danger'>Произогла ошибка при подтвержении регистрации.</div>";
            $this->error_code = $Answer[10];
            if ($this->debug) print_r($Answer);
            return false;
        }
    }

// Авторизация
    function login()
    {
        if ($this->debug) echo "<div class='alert alert-light'><div class='alert alert-heading'>Выполняется попытка авторизации</div>";
        //Попытка подключиться к модулю "Катологизатору"
        //$Packet = implode("\n", array('A', $this->arm, 'A', $this->id, $this->seq, $this->login));
        $Packet = implode("\n", array('A', $this->arm, 'A', $this->id, $this->seq, '', '', '', '', '', $this->login, $this->pass));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        //Если подключение не удалось, выводим ошибки
        //if ($Answer === 0) print_r($Answer);
        if (($Answer === false)) {
            $this->Error_Code = 1;
            if ($this->debug) echo "<div class='alert alert-danger'>Произошла ошибка при попытке авторизации!<p>";
            if ($Answer === false)  if ($this->debug) echo "Ответ от сервера не получен!";
            else  if ($this->debug) echo "Сервер вернул пустой ответ!";
            if ($this->debug) echo "<p></div></div>";
            return false;
        }

        //Если обнаружн код ошибки, выводим его на экран
        if (!empty($Answer[10])) {
            $this->Error_Code = $Answer[10];
        }

        if ($this->Error_Code != 0) return false;
        $this->server_timeout = $Answer[11];
        $this->server_ver = $Answer[4];
        if ($this->debug) echo "<div class='alert alert-success'>Авторизация прошла успешно!</div>";
        if ($this->debug) echo "</div>";
        return true;
    }



// Завершение сессии
    function logout()
    {
        if ($this->debug) echo "<div class='alert alert-primary'><div class='alert alert-heading'>Выход из системы</div>";
        $Packet = implode("\n", array('B', $this->arm, 'B', $this->id, $this->seq, '', '', '', '', '', $this->login));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) {
            if ($this->debug) echo "<div class='alert alert-danger'>Не получен ответ сервера при выходе из системы</div></div>";
            return false;
        }
        if (isset ($Answer[10])) {
            $this->Error_Code = $Answer[10];
            if ($this->Error_Code != 0) {
                if ($this->debug) echo "<div class='alert alert-danger'>Получен код ошибки при выходе из системы</div></div>";
                return false;
            }
        }
        if ($this->debug) echo "<div class='alert alert-success'>Вывод из системы успешно выполнен</div></div>";
        return true;
    }


// Получить максимальный MFN в базе
    function mfnMax()
    {
        $Packet = implode("\n", array('O', 'C', 'O', $this->id, $this->seq, '', '', '', '', '', 'PERIZ'));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        print_r($Packet);
        print_r($Answer);
        if ($Answer == false) return false;
        if (isset($Answer[11])) echo $Answer[11];
        if (!empty($Answer[10])) $this->Error_Code = $Answer[10];
        if ($this->Error_Code > 0) {
            $this->Error_Code = 0;
            return $Answer[10];
        } else {
            return false;
        }
    }

// Получить Версию Сервера Ирбис
    function getServerVersion()
    {
        $Packet = implode("\n", array('1', $this->arm, '1', $this->id, $this->seq, '', '', '', '', ''));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) return false;
        $this->Error_Code = $Answer[10];
        if ($this->Error_Code > 0) {
            $this->Error_Code = 0;
            return $Answer[10];
        } else {
            return false;
        }
    }

// Чтение словаря
    function termRead($term, $num_terms = '', $format = '')
    {
        // см. инструкцию сервера "7.8	Функции работы со словарем базы данных"
        // если указан формат, по в результат добавляются по одной записи для каждой строки словаря
        $Packet = implode("\n", array('H', $this->arm, 'H', $this->id, $this->seq, '', '', '', '', '', $this->DataBase, $term, $num_terms, $format));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) return false;
        print_r($Answer);
        $this->Error_Code = $Answer[10];
        if ($this->Error_Code == 0) {
            // массив $terms
            $terms = array();
            $c = count($Answer) - 1;
            for ($i = 11; $i < $c; $i++) {
                $terms[] = $Answer[$i]; // формат ЧИСЛО_ССЫЛОК#ТЕРМИН=ЗНАЧЕНИЕ
            }
            return $terms;
        } else return false;
    }

// Получить список ссылок термина
    function termRecords($term, $num_postings = '', $first_posting = '')
    {
        // $term - список терминов для поиска. формат: "K=фантастика\nK=природа" = вывести список соответствующих хотя бы одному из терминов
        // $num_postings = количество возвращаемых записей из списка, если = 0 то возвращается MAX_POSTINGS_IN_PACKET записей
        // если $first_posting = 0 - возвращается только количество записей, если больше - указывает смещение первой возвращаемой записи из списка
        $first_posting = (int)$first_posting;
        $Packet = implode("\n", array('I', $this->arm, 'I', $this->id, $this->seq, '', '', '', '', '', $this->DataBase, $num_postings, $first_posting, '', $term));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet, true);
        if ($Answer === false) return false;
        $this->Error_Code = $Answer[10];
        /* основной формат для результатов поиска
                MFN#TAG#OCC#CNT (см. инструкцию к серверу "6.5.3.1	Обыкновенный формат записи IFP")
                    MFN – номер записи;
                    TAG – идентификатор поля назначенный при отборе терминов в словарь;
                    OCC – номер повторения;
                    CNT – номер термина в поле.
        */

        if ($this->Error_Code == 0) {
            $records = array();
            $c = count($Answer) - 1;
            for ($i = 11; $i < $c; $i++) {
                $ret = explode('#', $Answer[$i]);
                // для упрощения возвращаем только список MFN
                // или количество найденных записей (при $first_posting == 0)
                $records = $ret;
            }
            return $records;
        } else return false;
    }

// Получить запись
    function recordRead($mfn, $lock = false)
    {
        /*
            record (
                mfn
                status - состояние записи
                ver - версия записи
                fileds - массив полей записи в формате [номер][повторение] = значение
            )
        */
        $Packet = implode("\n", array('C', $this->arm, 'C', $this->id, $this->seq,  $this->pass, $this->login, '', '', '', $this->DataBase, $mfn, $lock ? 1 : 0, '' ,'', "@" ));
        $Packet = strlen($Packet) . "\n" . $Packet;
        $Answer = $this->sendPacket($Packet);
        if ($Answer === false) return false;
        $this->Error_Code = $Answer[10];
        $mfn_status = explode('#', $Answer[11]);
        $rec_version = explode('#', $Answer[12]);
        $record = array(
            'mfn' => $mfn_status[0],
            'status' => (isset($mfn_status[1]) && $mfn_status[1] != '') ? $mfn_status[1] : 0,
            'ver' => isset($rec_version[1]) ? $rec_version[1] : 0
        );
        if ($this->Error_Code != 0) return false;
        $record['fields'] = array();
        $c = count($Answer) - 1;
        for ($i = 13; $i < $c; $i++) {
            preg_match("/(\d+?)#(.*?)/U", $Answer[$i], $matches);
            $field_num = (int)$matches[1];
            $field_val = $matches[2];
            $record['fields'][$field_num][] = $field_val;
        }
        return $record;
    }

// Поиск записей по запросу
    function recordsSearch($Query, $num_records = 1, $first_record = 0, $format = '@', $min = null, $max = null, $expression = null)
    {
        if ($this->debug) echo "<div class='alert alert-light'><div class='alert alert-heading'>Выполняется попытка поиска записей</div>";
        if ($this->debug) echo "<div class='alert alert-info'>Начался поиск записей по ключу: " . $Query . PHP_EOL ." </div>";
        if ($expression != '')  if ($this->debug) echo "<div class='alert alert-info'>C уточняющими условиями " . $expression . PHP_EOL ." </div>";

        // $search_exp = выражение для прямого поиска
        //		IBIS "I=шифр документа"
        //		IBIS "MHR=место хранения экз-ра"
        //		IBIS "K=ключевые слова"
        //		RDR "A=фио читателя"

        // $num_records = ограничение количества выдаваемых записей
        // 0 - возвращается количество записей не больше MAX_POSTINGS_IN_PACKET

        // $first_record = задает смещение с какой записи возвращать результаты
        // 0 - возвращается только количество найденных записей

        // $format = @ - оптимизированный (см. описание сервера "7.9.1 Поиск записей по заданному поисковому выражению (K)")
        // $format = '@brief' - оптимизированный сокращенный формат (см. BRIEF.PFT - выводится в список записей в окне каталогизатора)

        // $min, $max, $expression - для последовательного поиска. $expression = условие отбора

        //$Packet = implode("\n", array('K', $this->arm, 'K', $this->id, $this->seq, '', '', '', '', '', $this->DataBase, '"'.$Query.'"', $num_records, $first_record, $format, $min, $max, $expression));
        //Начинаем замер времени поиска
        $timeStart = (float)microtime();

        $searchNumber = 0;

        for ($i=0; $i<4; $i++) {
            $Packet = implode("\n", array('K',  $this->arm, 'K', $this->id, $this->seq++, $this->pass, $this->login, '', '', '', $this->DataBase[$i], $Query, $num_records, $first_record, $format));
            //$Packet = implode("\n", array('K',  $this->arm, 'K', $this->id, $this->seq++, '', '', '', '', '', $this->DataBase, $Query, $num_records, $first_record, $format));
            $Packet = strlen($Packet) . "\n" . $Packet;

            //$Packet = "K C K 558008 3 11 1 FOND \"A=Петров$\" 0 1 0 0";
            $Answer = $this->sendPacket($Packet);
            if ($Answer === false) {
                if ($this->debug) echo "<div class='alert alert-danger'>Не получен ответ от сервера выполнении поиска записей</div></div>";
                return false;
            }
            if ($Answer[10] != 0) {
                $this->Error_Code = $Answer[10];
                $result[$this->DataBase[$i]]['error_code'] = $this->Error_Code;
                if ($this->debug) echo "<div class='alert alert-danger'>Получен код ошибки при выполнении поиска</div></div>";
                return $result;
            }
            if (!empty($Answer[11])) {
                if (!empty($Answer[11]))  if ($this->debug) echo "<div class='alert alert-success'>Количество найденных записей = " . $Answer[11] . "</div>";
                $searchNumber += $Answer[11]; // количество найденных записей
            } else {
                if ($this->debug) echo "<div class='alert alert-warning'>По вашему запросу ничего не найденно</div>";
            }

            $c = count($Answer) - 1;
            for ($j = 11; $j < $c; $j++) {
                $result[$this->DataBase[$i]]['records'][] = $Answer[$j];
            }
        }

        $result['searchNumber'] = $searchNumber;

        if ($this->debug) echo "</div>";
        $searchTime = (float)microtime() - $timeStart;
        $searchTime = substr($searchTime,0,-3);
        $result['searchTime'] = $searchTime*10;
        $result['error_code'] = $this->Error_Code;
        return $result;
    }


    function sendPacket($Packet)
    {
        if ($this->debug) echo "<div class='alert alert-dark'>";
        if ($this->debug) echo "<div class='alert alert-heading'>Отправка пакета на сервер.</div>";
        if ($this->sock === false) {
            if ($this->debug)  echo "<div class='alert alert-danger'>Произошла ошибка при содании сокета!</div></div>";
            return false;
        } else {
            if ($this->debug) echo "<div class='alert alert-success'>Сокет соединения успешно создан!</div>";
        }
        if ($this->connect()) {
            if ($this->debug)  echo "<div class='alert alert-success'>Соединение к сервером библиотеки для отправки пакета открыто!</div>";
        } else {
            if ($this->debug) echo "<div class='alert alert-danger'>Ошибка при соединении с сервером во время попытки отправить пакет! </div></div>";
            return false;
        }
        $this->seq++;

        if ($this->debug) echo "<div class='alert alert-info'>Отправленный на сервер пакет: " . $Packet . PHP_EOL . "</div>";
        if (socket_write($this->sock, $Packet, strlen($Packet))) {
            if ($this->debug)  echo "<div class='alert alert-success'>Пакет ---><b>'".$Packet."'</b><--- был отправлен на сервер</div>";
        } else {
            if ($this->debug)  echo "<div class='alert alert-danger'>Отправка пакета на сервер не удалась!</div>";
        }
        $Answer = '';
        if ($this->debug) echo "<div class='alert alert-primary'><div class='alert alert-heading'>Ожидание ответа от сервера</div>";
        /*
         * if ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
            $get_answer = 1;
            echo "<div class='alert alert-success'>Получен ответ от сервера</div></div>";
            while ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
                $Answer .= $buf;
            }
        } else {
            $get_answer = 0;
            echo "<div class='alert alert-danger'>Сервер не ответил на отправленный пакет!</div></div>";
        }/
        */
        while ($buf = @socket_read($this->sock, 2048, PHP_NORMAL_READ)) {
                $Answer .= $buf;

                $get_answer = 1;
        }

        if ($this->debug)  print_r($Answer);

        if ($get_answer == 1) {
            if ($this->debug)  echo "<div class='alert alert-success'>Получен ответ от сервера</div></div>";
            $result['code'] = $Answer[10];
        } else {
            if ($this->debug)  echo "<div class='alert alert-danger'>Сервер не ответил на отправленный пакет!</div></div>";
        }

        if ($this->debug) echo "<div class='alert alert-info'>Полученный ответ от сервера: <p>";
        if ($this->debug) print_r($Answer);
        if ($this->debug) echo "</div>";

        socket_close($this->sock);
        if ($this->debug) echo "<div class='alert alert-warning'>Сокет соединения закрыт</div>";
        //echo "<div class='alert alert-primary'>
        //    <p>Ответ сервера на отправленный пакет: </p>
        //    <p>Отправленный пакет: " . $Packet . "</p>
        //    <p>Полученный ответ: " . $Answer . "</p>";
        if ($get_answer) {
            //Если ответ получен, выводим ответ на экран
            //echo "<p class='alert alert-success'>Ответ: " . $Answer . "</p></div></div>";
            if ($this->debug) echo "</div>";
        } else {
            if ($this->debug) echo "<p class='alert alert-danger'>С сервера поступил пустой ответ!</p></div></div>";
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

}// class
?>
