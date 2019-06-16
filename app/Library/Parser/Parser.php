<?php

namespace App\Library;

//Сласс парсер
class Parser {

    public $debug = false;

    public $error = "Ошибка при парсинге";

    //Id книги в базе
    public $Id = "";
    //Автор
    public $Author = "";
    //Заглавие
    public $Title = "";
    //Вид издания
    public $ViewOfPublication = "";
    //Тип издания
    public $TypeOfPublication = "";
    //Количество экземпляров
    public $NumberOfCopies = "";
    //Год издания
    public $YearOfPublication = "(=^.^=)";
    //Краткое описание
    public $SmallDescription = "";
    //Ссылка на книгу
    public $Link = "(=^.^=)";
    //Город издания
    public $CityOfPublication = "";

    //Финальный массив
    public $ResultParseArray = [];

    //Метод очистки
    public function getCleanString($line) {
        $line  =  str_replace(  "<b>",  "",  $line  );
        $line  =  str_replace(  "</b>",  "",  $line  );
        $line  =  str_replace(  "<br>",  "",  $line  );
        $line  =  str_replace(  "</br>",  "",  $line  );
        $line  =  str_replace(  "<tr>",  "",  $line  );
        $line  =  str_replace(  "</tr>",  "",  $line  );
        $line  =  str_replace(  "<dd>",  "",  $line  );
        $line  =  str_replace(  "</dd>",  "",  $line  );
        $line  =  str_replace(  "<table width=\"100%\">",  "",  $line  );
        $line  =  str_replace(  "</table>",  "",  $line  );
        $line  =  str_replace( "<td>", "", $line);
        $line  =  str_replace( "</td>", "", $line);
        $line  =  str_replace( "<td width=\"50%\">", "", $line);
        $line  =  str_replace( "", "", $line);
        $line  =  trim($line);
        $line  =  trim($line);
        $line  =  trim($line);
        //$line = str_replace("[", "", $line);
        //$line = str_replace("]", "", $line);
        return $line;
    }

    //Метод получения Автора
    function getId($line) {
        //Получение Автора
        $line = explode("#", $line);
        $Id = $line[0];
        if ($this->debug) echo "<div class='alert alert-success'><p>Id: ".$Id."</p></div>";
        $this->Id = trim($Id);
    }

    //Метод получения Автора
    function getAuthor($line) {
        //Получение Автора
        try {
            $Records = explode("<br> </b> <b>", $line);
            $line = explode("</b>", $Records[1]);
            $Author = $line[0];
            if ($this->debug) echo "<div class='alert alert-success'><p>Автор: ".$Author."</p></div>";
            $this->Author = trim($this->getCleanString($Author));
            $this->Author = trim($this->Author);
        } catch (Exception $exception) {}
        return $line[1];
    }

    //Метод получения Заглавия книги
    function getTitle($line) {

        $line = "<dd>".$line;
        //Получение Заглавия
        try {
            $Records = explode("<dd>", $line);
            $line = explode(" [", $Records[1]);
            $Title = $line[0];
        } catch (Exception $exception) {}
        if ($this->debug) echo "<div class='alert alert-success'><p>Название: ".$Title."</p></div>";
        $this->Title = trim($this->getCleanString($Title));
        return $line[1];
    }

    //Метод получения вида издания
    function getViewOfPublication($line) {
        if (strpos($line, "[Текст]")) $this->ViewOfPublication = "[Текст]";
            else if (strpos($line, "[Электронный ресурс]")) $this->ViewOfPublication = "[Электронный ресурс]";
            //else $ViewOfPublication = "Вид издания неизвестен";
        /*
        $line = explode(" [", $line);
        $line = explode("] : ", $line[1]);
        $ViewOfPublication = $line[0];
        if ($this->debug) echo "<div class='alert alert-success'><p>Вид издания: ".$ViewOfPublication."</p></div>";
        $ViewOfPublication = trim($this->getCleanString($ViewOfPublication));
        $ViewOfPublication = trim($this->getCleanString($ViewOfPublication));
        $this->ViewOfPublication = "[".$ViewOfPublication."]";
        */
        }

    //Метод получения типа издания
    function getTypeOfPublication($line) {
        try {
            $Records = explode("]", $line);
            $line = explode("/", $Records[1]);
            $TypeOfPublication = str_replace(":", "", $line[0]);
            if ($this->debug) echo "<div class='alert alert-success'><p>Тип издания: ".$TypeOfPublication."</p></div>";
            $this->TypeOfPublication = trim($this->getCleanString($TypeOfPublication));
        } catch (Exception $exception) {
            $this->TypeOfPublication = "Неизвестно";
        }
    }

    //Метод получения общего количества экземпляров в библиотеке
    //Можно вводить как полную строку так и урезанную
    //Для большей точности лучше использовать урезанную строку поиска
    function getNumberOfCopies($line) {
        try {
            $Records = explode("<b>Имеются экземпляры в отделах: </b>", $line);
            $line = explode(")<br>", $Records[1]);
            $line = explode("всего ", $line[0]);
            $line = explode(" : ", $line[1]);
            $NumberOfCopies = $line[0];
            if ($this->debug) echo "<div class='alert alert-success'><p>Количество экземпляров: ".$NumberOfCopies."</p></div>";
            $this->NumberOfCopies = trim($this->getCleanString($NumberOfCopies));
        } catch (Exception $exception) {}
    }

    //Метод получения общего количества экземпляров в библиотеке
    //Можно вводить как полную строку так и урезанную
    //Для большей точности лучше урезанную
    function getCityOfPublication($line) {
    
        //Не работает на сервере библиотеки ЮГУ
        try {
            $string = ". - "."!|([0-9]{1-2})|!"." -е изд.";
            if (strpos(mb_strtoupper($line), mb_strtoupper($string))) {
                //Обрезаем строку до города
                $Records = explode("$string", $line);
                $Records = $Records[1];
                //Обрезаем строку до города
                $Records = explode(". - ", $Records);
                $Records = $Records[1];
                //Обрезаем строку после города
                $Records = explode(" : ", $Records);
                $Records = $Records[0];
            } else {
                //Обрезаем строку до города
                $Records = explode(". - ", $line);
                $Records = $Records[1];
                //Обрезаем строку после города
                $Records = explode(" : ", $Records);
                $Records = $Records[0];
            }
            $CityOfPublication = $Records;
            if ($this->debug) echo "<div class='alert alert-success'><p>Город издания: ".$CityOfPublication."</p></div>";
            //$this->CityOfPublication = trim($this->getCleanString($CityOfPublication));
            $this->CityOfPublication = "Москва";
            
        } catch (Exception $exception) {
            $this->CityOfPublication = "Неопределен";
        }
    }

    //Получение года издания
    function getYearOfPublication($line) {
        $this->YearOfPublication = preg_replace("!|, ([0-9]{4}+[. -]{3})|.!", "\\1 ", $line);
        //Получение последнего года издания
        $this->YearOfPublication = preg_replace("!|([0-9]{4})|.!", "\\1 ", $this->YearOfPublication);
        if ($this->debug) echo "<div class='alert alert-success'><p>Год издания: ".$this->YearOfPublication."</p></div>";
        $this->YearOfPublication = trim($this->getCleanString($this->YearOfPublication));
    }


    //Метод составления результирующего массива
    function getFinalArray() {
        if (!empty($this->Id)) $this->ResultParseArray['Id'] = $this->Id;
        if (!empty($this->Author)) $this->ResultParseArray['Author'] = $this->Author;
        if (!empty($this->Title)) $this->ResultParseArray['Title'] = $this->Title;
        if (!empty($this->ViewOfPublication)) $this->ResultParseArray['ViewOfPublication'] = $this->ViewOfPublication;
        if (!empty($this->TypeOfPublication)) $this->ResultParseArray['TypeOfPublication'] = $this->TypeOfPublication;
        if (!empty($this->YearOfPublication)) $this->ResultParseArray['YearOfPublication'] = $this->YearOfPublication;
        if (!empty($this->NumberOfCopies)) $this->ResultParseArray['NumberOfCopies'] = $this->NumberOfCopies;
        if (!empty($this->SmallDescription)) $this->ResultParseArray['SmallDescription'] = $this->SmallDescription;
        if (!empty($this->Link)) $this->ResultParseArray['Link'] = $this->Link;
        if (!empty($this->CityOfPublication)) $this->ResultParseArray['CityOfPublication'] = $this->CityOfPublication;
        return $this->ResultParseArray;
    }

    //Функция парсинга строки
    function getFullParse($line) {
        if ($this->debug) echo "<div class='alert alert-info'>Началась работа парсера</div>";
        $this->getId($line);
        //Вытягиваем год издания
        $this->getYearOfPublication($line);
        $result = $this->getAuthor($line);
        $result = $this->getTitle($result);
        $this->getViewOfPublication($line);
        $this->getTypeOfPublication($line);
        $this->getNumberOfCopies($line);
        $result = $this->getFinalArray();
        if ($this->debug) echo "<div class='alert alert-info'>Работа парсера звершена</div></br>";
        return $this->ResultParseArray;
    }

    function getSmallDescription($line) {
        try {
            $Records = explode("<dd>", $line);
            $line = explode(" - <b>ISBN </b>", $Records[1]);
            if (strpos($line[0], "<b> ББК </b>")) $line = explode("<b> ББК </b>", $line[0]);
            $this->SmallDescription = $line[0];
            if ($this->debug) echo "<div class='alert alert-success'><p>Описание издания: ". $this->SmallDescription ."</p></div>";
            $this->SmallDescription = $this->getCleanString($this->SmallDescription);
        } catch (Exception $exception) {
            $this->SmallDescription = "Неизвестно";
        }
    }

    function getLink($line) {
        try {
            if (strpos($line, '<a href="https:\\"')) {
                $line = explode('<a href="https:\\"', $line);
                $line = explode('">', $line[1]);
                $line = "https://".$line[0];
            }
            echo $line;
            $this->Link = $line;
            if ($this->debug) echo "<div class='alert alert-success'><p>Ссылка на литературу: ". $this->Link ."</p></div>";
        } catch (Exception $exception) {
            $this->Link = "(=^.^=)";
        }
    }

    //Функция парсинга строки
    function getSmallParse($line) {
        if ((strlen($line))>10) {
            if ($this->debug) echo "<div class='alert alert-info'>Началась работа парсера</div>";
            $this->getId($line);
            $this->getAuthor($line);
            $this->getViewOfPublication($line);
            $this->getSmallDescription($line);
            $this->getYearOfPublication($line);
            $this->getCityOfPublication($line);
            if (strpos($line,"Имеются экземпляры в отделах")) {
                $this->getNumberOfCopies($line);
            }
            if (strpos($line, "[Электронный ресурс]")) {
                if (strpos($line, '<a href="https://')) {
                    $this->NumberOfCopies = "Неограниченно";
                        $this->getLink($line);
                } else {
                }
            }
        }
        $this->getFinalArray();
        if ($this->debug) echo "<div class='alert alert-info'>Работа парсера звершена</div></br>";
        return $this->ResultParseArray;
    }



}