<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 04.06.2019
 * Time: 12:12
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BookSearchFilter extends Model
{

    //Фильтруем литературу по автору
    public function filterByAuthor($Author, $Literature)
    {
        $Result = [];
        $Author = trim($Author);
        $j = 0;
        for ($i = 0; $i < count($Literature); $i++) {
            if (isset($Literature[$i]['Author'])) {
                $pos = strpos(mb_strtoupper($Literature[$i]['Author']), mb_strtoupper($Author));
                if ($pos === false) {} else {
                    $Result[$j] = $Literature[$i];
                    $j++;
                }
            }
        }
        return $Result;
    }

    //Фильтруем литературу по стоп словам
    public function filterByStopWord($StopWords, $Literature)
    {
        $StopWords = explode(",", $StopWords);
        for($i = 0; $i <= count($StopWords)-1; $i++) {
            $StopWords[$i] = mb_strtoupper(trim($StopWords[$i]));
        }
        $Result = [];
        $j = 0;
        for ($i = 0; $i < count($Literature); $i++) {
            if (isset($Literature[$i]['SmallDescription'])) {
                $col = 0;
                for($d = 0; $d <= (count($StopWords))-1; $d++) {
                    $pos = (strpos(mb_strtoupper($Literature[$i]['SmallDescription']), (mb_strtoupper($StopWords[$d]))));
                    if ($pos === false) {
                    } else {
                        $col++;
                    }
                }
                if ($col == 0) {
                    $Result[$j] = $Literature[$i];
                    $j++;
                }
            }
        }
        return $Result;
    }

    public function filterByOldYearOfPublication($Literature) {
        $LastYear = date('Y')-19;
        $Result = [];
        $j = 0;
        for ($i = 0; $i < count($Literature); $i++) {
            if (isset($Literature[$i]['YearOfPublication'])) {
                if ((int)($Literature[$i]['YearOfPublication']) < $LastYear) {
                } else {
                    $Result[$j] = $Literature[$i];
                    $j++;
                }
            }
        }
        return $Result;
    }

    public function filterByStock($Literature) {
        $MinStock = 3;
        $Result = [];
        $j = 0;
        for ($i = 0; $i < count($Literature); $i++) {
            $pos = (strpos(mb_strtoupper($Literature[$i]['SmallDescription']), (mb_strtoupper("[Электронный ресурс]"))));
            if ($pos === false) {
                if (isset($Literature[$i]['NumberOfCopies'])) {
                    if ($Literature[$i]['NumberOfCopies'] !== "Неограниченно") {
                        if ($Literature[$i]['NumberOfCopies'] >= $MinStock) {
                            $Result[$j] = $Literature[$i];
                            $j++;
                        }
                    }
                }
            } else {
                $Result[$j] = $Literature[$i];
                $j++;
            }
        }
        return $Result;
    }

    public function filterByCountStudents($Literature, $CountLiterature) {
        $Result = [];
        $j = 0;
        for ($i = 0; $i < count($Literature); $i++) {
            $pos = (strpos(mb_strtoupper($Literature[$i]['SmallDescription']), (mb_strtoupper("[Электронный ресурс]"))));
            if ($pos === false) {
                if (isset($Literature[$i]['NumberOfCopies'])) {
                    if ($Literature[$i]['NumberOfCopies'] !== "Неограниченно") {
                        if ($Literature[$i]['NumberOfCopies'] >= $CountLiterature) {
                            $Result[$j] = $Literature[$i];
                            $j++;
                        }
                    }
                }
            } else {
                $Result[$j] = $Literature[$i];
                $j++;
            }
        }
        return $Result;
    }
}