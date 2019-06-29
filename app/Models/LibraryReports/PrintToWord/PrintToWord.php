<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 05.06.2019
 * Time: 15:33
 */

namespace App\Models\LibraryReports\PrintToWord;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;

class PrintToWord extends Model
{
    //Запись только одного вида литературы
    public function setOnlyOneViewBooks($template, $view, $Literature, $amount, $row) {
        $T_TEXT = "Печатные учебные издания";
        $E_TEXT = "Электронные учебные издания, имеющиеся в электронном каталоге электронно-библиотечной системы";
        //Если есть только печатная литература
        //1. Удаляем поле для второго вида литературы
        $template->cloneRow("two_literature_#".$row, 0);
        //2. Записываем вид литературы
        ($view == 0) ? $template->setValue("one_literature_#".$row, $T_TEXT) : $template->setValue("one_literature_#".$row, $E_TEXT);
        //3.Записываем первую литературу и ее количество
        $template->setValue("one_books_#".$row, "1. ".$Literature[0]['Book']);
        ($Literature[0]['Memory'] == 0) ? $template->setValue("one_memory_#".$row, "") : $template->setValue("one_memory_#".$row, "(Дополнительная)");
        $template->setValue("One_NumberOfCopies_#".$row, $Literature[0]['NumberOfCopies']);
        

        if (isset($Literature[0]['Max'])) {
            if ($Literature[0]['Max'] == "Неограниченно")  $template->setValue("One_NumberOfCopies_#".$row, "1");
        }
        

        $template->setValue("One_NumberOfCopiesForStud_#".$row, "1");
        //4. Если тектовой литературы более 1 шт клонируем строку литературы нужное количество раз, если нет, то удаляем дополнительную строку
        $template->cloneRow("one_books_2#".$row, $amount);
                        

        if ($amount > 0) {
            //5.Остальное записываем по циклу
            for ($num = 1; $num <= $amount; $num++) {
                $column = $num + 1;
                $template->setValue("one_books_2#".$row."#".$num, $column.". ".$Literature[$num]['Book']);
                ($Literature[$num]['Memory'] == 0) ? $template->setValue("one_memory_2#".$row."#".$num, "") : $template->setValue("one_memory_2#".$row."#".$num, "(Дополнительная)");
                $template->setValue("one_memory_2#".$row."#".$num, $column.". ".$Literature[$num]['Book']);
                $template->setValue("One_NumberOfCopies_2#".$row."#".$num, $Literature[$num]['NumberOfCopies']);
                if (isset($Literature[$num]['Max'])) {
                    if ($Literature[$num]['Max'] == "Неограниченно")  $template->setValue("One_NumberOfCopies_2#".$row."#".$num, "1");
                }
                $template->setValue("One_NumberOfCopiesForStud_2#".$row."#".$num, "1");
            }
        }
        //6.Готово
    }

    //Запись обоих видов литературы
    public function setTwoViewBooks($template, $Literature, $row) {
        $t_amount = $Literature['AmountOftBookLiterature'];
        $e_amount = $Literature['AmountOfeBookLiterature'];
        $T_TEXT = "Печатные учебные издания";
        $E_TEXT = "Электронные учебные издания, имеющиеся в электронном каталоге электронно-библиотечной системы";
        //1. Записываем вид литературы
        $template->setValue("one_literature_#".$row, $T_TEXT);
        //2.Записываем первую литературу и ее количество
        $template->setValue("one_books_#".$row, "1. ".$Literature['tBook'][0]['Book']);
        ($Literature['tBook'][0]['Memory'] == 0) ? $template->setValue("one_memory_#".$row, "") : $template->setValue("one_memory_#".$row, "(Дополнительная)");
        $template->setValue("One_NumberOfCopies_#".$row, $Literature['tBook'][0]['NumberOfCopies']);
        $template->setValue("One_NumberOfCopiesForStud_#".$row, "1");
        //3. Если тектовой литературы более 1 шт клонируем строку литературы нужное количество раз, если нет, то удаляем дополнительную строку
        $template->cloneRow("one_books_2#".$row, $t_amount);
        if ($t_amount > 0) {
            //4.Остальное записываем по циклу
            for ($num = 1; $num <= $t_amount; $num++) {
                $column = $num + 1;
                $template->setValue("one_books_2#".$row."#".$num, $column.". ".$Literature['tBook'][$num]['Book']);
                ($Literature['tBook'][$num]['Memory'] == 0) ? $template->setValue("one_memory_2#".$row."#".$num, "") : $template->setValue("one_memory_2#".$row."#".$num, "(Дополнительная)");
                $template->setValue("one_memory_2#".$row."#".$num, $column.". ".$Literature['tBook'][$num]['Book']);
                $template->setValue("One_NumberOfCopies_2#".$row."#".$num, $Literature['tBook'][$num]['NumberOfCopies']);
                $template->setValue("One_NumberOfCopiesForStud_2#".$row."#".$num, "1");
            }
        }
        //5. Записываем вид литературы
        $template->setValue("two_literature_#".$row, $E_TEXT);
        //6.Записываем первую литературу и ее количество
        $template->setValue("two_books_#".$row, "1. ".$Literature['eBook'][0]['Book']);
        ($Literature['eBook'][0]['Memory'] == 0) ? $template->setValue("two_memory_#".$row, "") : $template->setValue("two_memory_#".$row, "(Дополнительная)");
        $template->setValue("Two_NumberOfCopies_#".$row, "1");
        $template->setValue("Two_NumberOfCopiesForStud_#".$row, "1");
        //7. Если тектовой литературы более 1 шт клонируем строку литературы нужное количество раз, если нет, то удаляем дополнительную строку
        $template->cloneRow("two_books_2#".$row, $e_amount);
        if ($e_amount > 0) {
            //8.Остальное записываем по циклу
            for ($num = 1; $num <= $e_amount; $num++) {
                $column = $num + 1;
                $template->setValue("two_books_2#".$row."#".$num, $column.". ".$Literature['eBook'][$num]['Book']);
                ($Literature['eBook'][$num]['Memory'] == 0) ? $template->setValue("two_memory_2#".$row."#".$num, "") : $template->setValue("two_memory_2#".$row."#".$num, "(Дополнительная)");
                $template->setValue("two_memory_2#".$row."#".$num, $column.". ".$Literature['eBook'][$num]['Book']);
                $template->setValue("Two_NumberOfCopies_2#".$row."#".$num, "1");
                $template->setValue("Two_NumberOfCopiesForStud_2#".$row."#".$num, "1");
            }
        }
        //9.Готово
    }

    public function printSpecial($year, $specialitycode, $forma)
    {
        //Получение справок выбранным году и специальности
        $LibraryReports =
            DB::table('MY_LR_DISC')
                ->select(['*'])
                ->where('SPECIALITYCODE','=', $specialitycode)
                ->where('YEARED', '=', $year)
                ->where('FORMA' , $forma)
                ->where('STATUS' , '=',10)
                ->orderBy('DISCIPLINE')
                ->distinct()
                ->get();


        //Количество составляемых дисциплин
        $AmountOfLibraryReport = count($LibraryReports);

        for ($i = 0; $i < $AmountOfLibraryReport; $i++) {
            $LibraryReports[$i]->literature = (unserialize(gzuncompress($LibraryReports[$i]->literature)));
        }
        
        
        //Создаем новый документ
        $phpWord = new PhpWord();
        //Загружаем шаблон
        $template = $phpWord->loadTemplate('docs/templates/Template.docx'); //шаблон

        //Указываем направление подготовки
        $template->setValue('br_special_special', $LibraryReports[0]->specialitycode. " - " . $LibraryReports[0]->speciality); //номер договора
        $template->setValue('br_special_year', $LibraryReports[0]->yeared);

        //клонируем тамблицу под количесво дисциплин
        $template->cloneRow('d_discipline_', $AmountOfLibraryReport);
        
        //Проходим все справки по циклу
        for ($i = 0; $i < $AmountOfLibraryReport; $i++) {
            $row = $i+1;
            //Сначало простое
            $template->setValue("d_discipline_number_#".$row, $row);
            $template->setValue("d_discipline_#".$row, $LibraryReports[$i]->discipline);
            //Простое закончилось
            //Теперь проверяем присутствуют ои оба вида литературы (Электронная и Печатная)
            if (((isset($LibraryReports[$i]->literature['AmountOftBookLiterature']))) AND ((isset($LibraryReports[$i]->literature['AmountOfeBookLiterature'])))) {
                (new PrintToWord())->setTwoViewBooks($template, $LibraryReports[$i]->literature, $row);
            } else if ((!isset($LibraryReports[$i]->literature['AmountOftBookLiterature']))) {
                //Если есть только печатная литература
                (new PrintToWord())->setOnlyOneViewBooks($template, 1, $LibraryReports[$i]->literature['eBook'], $LibraryReports[$i]->literature['AmountOfeBookLiterature'], $row);
            } else if ((!isset($LibraryReports[$i]->literature['AmountOfeBookLiterature']))) {
                //Если есть только печатная литература
                (new PrintToWord())->setOnlyOneViewBooks($template, 0, $LibraryReports[$i]->literature['tBook'], $LibraryReports[$i]->literature['AmountOftBookLiterature'], $row);
            }
        }

        //Сохраняем библиографическую справку
        //Дирректория хранения справок
        $pathPublic = "docs/library_reports/";
        $date = date("Y-m-d H-i");

        //if (!($template->saveAs($pathPublic."Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx"))) {
        if (!($template->saveAs($pathPublic."Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx"))) {
            //Формируем ссылку на собранную справку
            $link = env('APP_URL').$pathPublic."Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx";
            //Возвращаем ссылку на справку
            $message = [
                'message' => 'Справка успешно сохранена',
                'code' => 'success',
                'url' => $link,
                'name' => "Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx",
            ];
        } else {
            $message = [
                'message' => 'Не распечатать справку',
                'code' => 'error',
            ];
        }
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }

    public function printDisc($year, $specialitycode, $disciplinecode, $forma)
    {
        
        //Получение справок выбранным году и специальности
        $LibraryReports =
            DB::table('MY_LR_DISC')
                ->select(['*'])
                ->where('YEARED', '=', $year)
                ->where('SPECIALITYCODE','=', $specialitycode)
                ->where('DISCIPLINECODE' , '=',$disciplinecode)
                ->where('FORMA' , '=', $forma)
                ->where('STATUS' , '=',10)
                ->orderBy('DISCIPLINE')
                ->distinct()
                ->get();


        //Количество составляемых дисциплин
        $AmountOfLibraryReport = count($LibraryReports);

        for ($i = 0; $i < $AmountOfLibraryReport; $i++) {
            $LibraryReports[$i]->literature = (unserialize(gzuncompress($LibraryReports[$i]->literature)));
        }

        //Создаем новый документ
        $phpWord = new PhpWord();
        //Загружаем шаблон
        $template = $phpWord->loadTemplate('docs/templates/Template.docx'); //шаблон

        //Указываем направление подготовки
        $template->setValue('br_special_special', $LibraryReports[0]->specialitycode. " - " . $LibraryReports[0]->speciality); //номер договора
        $template->setValue('br_special_year', $LibraryReports[0]->yeared);

        //клонируем тамблицу под количесво дисциплин
        $template->cloneRow('d_discipline_', $AmountOfLibraryReport);

        
        
        
        
        
        //Проходим все справки по циклу
        for ($i = 0; $i < $AmountOfLibraryReport; $i++) {
            $row = $i+1;
        
            //Сначало простое
            $template->setValue("d_discipline_number_#".$row, $row);
            $template->setValue("d_discipline_#".$row, $LibraryReports[$i]->discipline);
        
            //Простое закончилось
            //Теперь проверяем присутствуют ои оба вида литературы (Электронная и Печатная)
            if (((isset($LibraryReports[$i]->literature['AmountOftBookLiterature']))) AND ((isset($LibraryReports[$i]->literature['AmountOfeBookLiterature'])))) {
                (new PrintToWord())->setTwoViewBooks($template, $LibraryReports[$i]->literature, $row);
            } else if ((!isset($LibraryReports[$i]->literature['AmountOftBookLiterature']))) {
                //Если есть только печатная литература
                (new PrintToWord())->setOnlyOneViewBooks($template, 1, $LibraryReports[$i]->literature['eBook'], $LibraryReports[$i]->literature['AmountOfeBookLiterature'], $row);
            } else if ((!isset($LibraryReports[$i]->literature['AmountOfeBookLiterature']))) {
                //Если есть только печатная литература
                (new PrintToWord())->setOnlyOneViewBooks($template, 0, $LibraryReports[$i]->literature['tBook'], $LibraryReports[$i]->literature['AmountOftBookLiterature'], $row);
            }
        }


        //Сохраняем библиографическую справку
        //Дирректория хранения справок
        $pathPublic = "docs/library_reports/";
        $date = date("Y-m-d H-i");

        //if (!($template->saveAs($pathPublic."Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx"))) {
        if (!($template->saveAs($pathPublic."Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx"))) {
            //Формируем ссылку на собранную справку
            $link = env('APP_URL').$pathPublic."Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx";
            //Возвращаем ссылку на справку
            $message = [
                'message' => 'Справка успешно сохранена',
                'code' => 'success',
                'url' => $link,
                'name' => "Библиографическая справка ".$LibraryReports[0]->specialitycode." - ".$LibraryReports[0]->speciality." (".$date.").docx",
            ];
        } else {
            $message = [
                'message' => 'Не распечатать справку',
                'code' => 'error',
            ];
        }
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }

}