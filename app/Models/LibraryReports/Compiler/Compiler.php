<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 30.05.2019
 * Time: 1:09
 */

namespace App\Models\LibraryReports\Compiler;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Compiler extends Model
{
    //Общие операции над справкой
    public function saveCreatingLocalLibraryReport($data)
    {
        $speciality = trim((explode(" | ", $data['speciality']))[1]);
        $fspecialitycode = trim((explode(" | ", $data['speciality']))[0]);
        $discipline = trim((explode(" | ", $data['discipline']))[1]);
        $disciplinecode = trim((explode(" | ", $data['discipline']))[0]);
        (isset($data['fgos'])) ? $fgos = trim($data['fgos']) : $fgos = NULL;
        //Проверяем что раньше такая справка не была создана
        $Check = DB::table('MY_LR_DISC')
            ->where('YEARED', trim($data["year"]))
            ->where('SPECIALITYCODE', $fspecialitycode)
            ->where('DISCIPLINECODE', $disciplinecode)
            ->get(['*']);
        if (!empty($Check[0])) {
            $Answer = [
                'message' => "Данная библиографическая справка уже составлялась. Вы можете загрузить ее для редактирования.",
                'code' => 'warning'
            ];
            return (json_encode($Answer));
        } else {
            $LibraryReport = [
                'Yeared' => trim($data['year']),
                'Yeareds' => (trim($data['year']) . "-" . trim($data['year'] + 1)),
                'SpecialityCode' => trim($fspecialitycode),
                'Speciality' => trim($speciality),
                'DisciplineCode' => trim($disciplinecode),
                'Discipline' => trim($discipline),
                'FGOS' => trim($fgos),
                'Compiler' => trim(Session::get('Authenticate.name')),
                'CreateDate' => date("Y-m-d H:i:s"),
                'Literature' => NULL,
                'Status' => '00',
                'UpdateDate' => NULL,
                'AddInFinalLibraryReport' => '0'
            ];
            Session::put('LibraryReportDiscLocal.Creating.Info', $LibraryReport);
            Session::save();
            $Answer = [
                'message' => "Данные библиографической справки сохранены, на время текущего сеанса",
                'code' => 'success'
            ];
            return (json_encode($Answer));
        }   
    }

    //Обновить информацию о составляемой библиографической справке
    public function updateCreatingLocalLibraryReport($data)
    {
        Session::put('LibraryReportDiscLocal.Creating.Info.Yeared', (trim($data['year'])));
        Session::put('LibraryReportDiscLocal.Creating.Info.Yeareds', ((trim($data['year']) . "-" . trim($data['year'] + 1))));
        Session::put('LibraryReportDiscLocal.Creating.Info.SpecialityCode', (trim((explode(" | ", $data['speciality']))[0])));
        Session::put('LibraryReportDiscLocal.Creating.Info.Speciality', (trim((explode(" | ", $data['speciality']))[1])));
        Session::put('LibraryReportDiscLocal.Creating.Info.DisciplineCode', (trim((explode(" | ", $data['discipline']))[0])));
        Session::put('LibraryReportDiscLocal.Creating.Info.Discipline', (trim((explode(" | ", $data['discipline']))[1])));
        Session::put('LibraryReportDiscLocal.Creating.Info.FGOS', ((isset($data['fgos'])) ? trim($data['fgos']) : NULL));
        Session::put('LibraryReportDiscLocal.Creating.Info.UpdateDate', date('Y-m-d H:i:s'));
        Session::save();
        $Answer = [
            'message' => "Данные библиографической справки изменены",
            'code' => 'success'
        ];
        return (json_encode($Answer));
    }

    //Очистить составляемую библиографичесую справку от литературы
    public function cleanCreatingLocalLibraryReport()
    {
        Session::forget('LibraryReportDiscLocal.Creating.Literature');
        return;
    }

    //Удалить составляемую библиографическую справку из сессии
    public function deleteCreatingLocalLibraryReport()
    {
        Session::forget('LibraryReportDiscLocal');
        return;
    }

    //Сохранить составляемую библиографическую справку в базе данных
    public function saveCreatingLibraryReportInDB()
    {
        if (Session::has('LibraryReportDiscLocal.Creating')) {
            if (Session::has('LibraryReportDiscLocal.Edit')) {
                //Получаем создаваемую справку из сессии
                $LibraryReport = Session::get('LibraryReportDiscLocal.Creating.Info');
                //Получаем выбранную литературу и сжимаем ее так как только лодумался
                $Literature = gzcompress(((serialize(Session::get('LibraryReportDiscLocal.Creating.Literature')))), 9);
                $Activity = Session::get('LibraryReportDiscLocal.Creating.Activity');
                $Activity[(count($Activity))] = ['ActivityDate' => date('Y-m-d H:i:s'), 'ActivityPerson' => Session::get('Authenticate.name'), 'ActivityStatus' => 2, 'ActivityComment' => NULL];
                //Сжимаем массив активности
                $Activity = gzcompress(((serialize($Activity))), 9);

                //Формируем запрос на запись справки в БД

                //Выполняем запрос на обновление в БД
                $Update = DB::table('MY_LR_DISC')
                    ->where('YEARED', $LibraryReport["Yeared"])
                    ->where('SPECIALITYCODE', $LibraryReport["SpecialityCode"])
                    ->where('DISCIPLINECODE', $LibraryReport["DisciplineCode"])
                    //->update(['STATUS' => 2]);
                    ->update(['LITERATURE' => $Literature, 'STATUS' => 2, 'UPDATEDATE' => (date('Y-m-d H:i:s')), 'ACTIVITY' => $Activity]);

                Session::forget('LibraryReportDiscLocal');
                Session::save();
                return;
            } else {
                //Получаем создаваемую справку из сессии
                $LibraryReport = Session::get('LibraryReportDiscLocal.Creating.Info');
                //Получаем выбранную литературу и сжимаем ее так как только лодумался
                $Literature = gzcompress(((serialize(Session::get('LibraryReportDiscLocal.Creating.Literature')))), 9);
                $Activity[0] = ['ActivityDate' => date('Y-m-d H:i:s'), 'ActivityPerson' => Session::get('Authenticate.name'), 'ActivityStatus' => 0, 'ActivityComment' => NULL];
                //Сжимаем массив активности
                $Activity = gzcompress(((serialize($Activity))), 9);
                //Формируем запрос на запись справки в БД
                $QUERY = "INSERT INTO MY_LR_DISC (
                                      YEARED, YEAREDS, 
                                      SPECIALITYCODE, SPECIALITY, 
                                      DISCIPLINECODE, DISCIPLINE, 
                                      FGOS, COMPILER, CREATEDATE, 
                                      LITERATURE, STATUS, UPDATEDATE, 
                                      ADDEDINFINALLIBRARYREPORT, ACTIVITY) 
                                    VALUES (:YEARED, :YEAREDS, 
                                      :SPECIALITYCODE, :SPECIALITY, 
                                      :DISCIPLINECODE, :DISCIPLINE, 
                                      :FGOS, :COMPILER, :CREATEDATE, 
                                      :LITERATURE, :STATUS, :UPDATEDATE, 
                                      :ADDEDINFINALLIBRARYREPORT, :ACTIVITY)";
                //Формируем массив атрибутов
                $VALUES = [
                    'YEARED' => $LibraryReport['Yeared'],
                    'YEAREDS' => $LibraryReport['Yeareds'],
                    'SPECIALITYCODE' => $LibraryReport['SpecialityCode'],
                    'SPECIALITY' => $LibraryReport['Speciality'],
                    'DISCIPLINECODE' => $LibraryReport['DisciplineCode'],
                    'DISCIPLINE' => $LibraryReport['Discipline'],
                    'FGOS' => $LibraryReport['FGOS'],
                    'COMPILER' => $LibraryReport['Compiler'],
                    'CREATEDATE' => date('Y-m-d H:i:s'),
                    'LITERATURE' => $Literature,
                    'STATUS' => 0,
                    'UPDATEDATE' => NULL,
                    'ADDEDINFINALLIBRARYREPORT' => '0',
                    'ACTIVITY' => $Activity
                ];
                //Выполняем запрос на запись в БД
                if (DB::insert($QUERY, $VALUES)) {
                    echo "Новая справка успешно добавленна в базу данных";
                } else {
                    echo "Не удалось записать справку в базу данных";
                }
                return;
            }
        } else {
            return;
        }
    }

    //Возвращает информацию о БС хранимую в сессии
    public function getCreatingLocalLibraryReport()
    {
        $LibraryReportInfo = (Session::get('LibraryReportDiscLocal.Creating.Info'));
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOftBookLiterature'))
            ? $AmountOftBookLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOftBookLiterature') + 1)
            : $AmountOftBookLiterature = 0;
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfeBookLiterature'))
            ? $AmountOfeBookLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfeBookLiterature') + 1)
            : $AmountOfeBookLiterature = 0;
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature'))
            ? $AmountOfBaseLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature') + 1)
            : $AmountOfBaseLiterature = 0;
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature'))
            ? $AmountOfDLCLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature') + 1)
            : $AmountOfDLCLiterature = 0;
        $AmountOfLiterature = $AmountOftBookLiterature + $AmountOfeBookLiterature;
        (Session::has('LibraryReportDiscLocal.Creating.Literature.tBook'))
            ? $tBook = (Session::get('LibraryReportDiscLocal.Creating.Literature.tBook'))
            : $tBook = NULL;
        (Session::has('LibraryReportDiscLocal.Creating.Literature.eBook'))
            ? $eBook = (Session::get('LibraryReportDiscLocal.Creating.Literature.eBook'))
            : $eBook = NULL;
        $LibraryReport = [
            'LibraryReport' => $LibraryReportInfo,
            'AmountOfLiterature' => $AmountOfLiterature,
            'AmountOftBookLiterature' => $AmountOftBookLiterature,
            'AmountOfeBookLiterature' => $AmountOfeBookLiterature,
            'AmountOfBaseLiterature' => $AmountOfBaseLiterature,
            'AmountOfDLCLiterature' => $AmountOfDLCLiterature,
            'tBook' => $tBook,
            'eBook' => $eBook
        ];
        return $LibraryReport;
    }


    //Возвращает все библиографические справки составленные пользователем
    public function getAllFromAllLibraryReportSToPerson($PERSON)
    {
        $Counts = 0;
        $LibraryReports = NULL;
        //Получение всех составленных пользователем БС
        $LibraryReports =
            DB::table('MY_LR_DISC')
                ->select(['YEARED', 'SPECIALITYCODE', 'SPECIALITY', 'DISCIPLINECODE', 'DISCIPLINE', 'CREATEDATE', 'UPDATEDATE', 'STATUS'])
                ->where('COMPILER', $PERSON)
                ->orderBy('SPECIALITY')
                ->orderBy('DISCIPLINE')
                ->orderByDesc('CREATEDATE')
                ->get();
        $Answer = [
            'Counts' => $Counts,
            'LibraryReports' => $LibraryReports
        ];
        return $Answer;
    }

    //Операции над литературой в этой справке
    //Добавлеяет печатную литературу на хранение в сессии
    public function addtBookInCreatingLocalLibraryReport($literature)
    {
        //Восстанавливаем литературу
        $AddBook = [
            'Id' => $literature['Id'],
            'Author' => $literature['Author'],
            'SmallDescription' => $literature['SmallDescription'],
            'NumberOfCopies' => $literature['NumberOfCopies'],
            'Book' => $literature['Author'] . ". " . $literature['SmallDescription'],
            'Max' => $literature['Max'],
            'Memory' => $literature['Type']
        ];
        if ($literature['Type'] == 0) {
            //Проверяем имеется ли в данный момент литература в основной литературе
            (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature'))
                ? ($AmountOfBaseLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature')) + 1)
                : $AmountOfBaseLiterature = 0;
            Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature', $AmountOfBaseLiterature);
        } else {
            //Проверяем имеется ли в данный момент литература в дополнительной литературе
            (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature'))
                ? ($AmountOfDLCLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature')) + 1)
                : $AmountOfDLCLiterature = 0;
            Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature', $AmountOfDLCLiterature);
        }
        ///Проверяем имеется ли в данный момент литература в составляемой справке
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature'))
            ? ($AmountOfLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature')) + 1)
            : $AmountOfLiterature = 0;
        //Сразу обновляем количество хранимой литературы на данный момент с учетом добавляемой
        Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature', $AmountOfLiterature);
        //Проверяем есть ли на данным момент в справке печатные издания
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOftBookLiterature'))
            ? ($AmountOftBookLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOftBookLiterature')) + 1)
            : $AmountOftBookLiterature = 0;
        //Сразу обновляем количество хранимой печатной литературы на данный момент с учетом добавляемой
        Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOftBookLiterature', $AmountOftBookLiterature);
        //Добавляем литературу на хранение в сессиию
        Session::put('LibraryReportDiscLocal.Creating.Literature.tBook.' . $AmountOftBookLiterature, $AddBook);
        //Сохраняем добавленную информацию в сессиию
        Session::save();
        return;
    }

    //Добавлеяет электронную литературу на хранение в сессии
    public function addeBookInCreatingLocalLibraryReport($literature)
    {
        //Восстанавливаем литературу
        ($literature['Link'] != "(=^_^=)") ? $Link = $literature['Link'] : $Link = "";
        $AddBook = [
            'Id' => $literature['Id'],
            'Author' => $literature['Author'],
            'SmallDescription' => $literature['SmallDescription'],
            'NumberOfCopies' => '1',
            'CityOfPublication' => $literature['CityOfPublication'],
            'Book' => $literature['Author'] . ". " . $literature['SmallDescription'] . " ". $Link,
            'Max' => 'Неограниченно',
            'Memory' => $literature['Type']
        ];
        if ($literature['Type'] == 0) {
            //Проверяем имеется ли в данный момент литература в основной литературе
            (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature'))
                ? ($AmountOfBaseLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature')) + 1)
                : $AmountOfBaseLiterature = 0;
            Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfBaseLiterature', $AmountOfBaseLiterature);
        } else {
            //Проверяем имеется ли в данный момент литература в дополнительной литературе
            (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature'))
                ? ($AmountOfDLCLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature')) + 1)
                : $AmountOfDLCLiterature = 0;
            Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfDLCLiterature', $AmountOfDLCLiterature);
        }
        //Проверяем имеется ли в данный момент литература в составляемой справке
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature'))
            ? ($AmountOfLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature')) + 1)
            : $AmountOfLiterature = 0;
        //Сразу обновляем количество хранимой литературы на данный момент с учетом добавляемой
        Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfLiterature', $AmountOfLiterature);
        //Проверяем есть ли на данным момент в справке электронные издания
        (Session::has('LibraryReportDiscLocal.Creating.Literature.AmountOfeBookLiterature'))
            ? ($AmountOfeBookLiterature = (Session::get('LibraryReportDiscLocal.Creating.Literature.AmountOfeBookLiterature')) + 1)
            : $AmountOfeBookLiterature = 0;
        //Сразу обновляем количество хранимой электронной литературы на данный момент с учетом добавляемой
        Session::put('LibraryReportDiscLocal.Creating.Literature.AmountOfeBookLiterature', $AmountOfeBookLiterature);
        //Добавляем литературу на хранение в сессиию
        Session::put('LibraryReportDiscLocal.Creating.Literature.eBook.' . $AmountOfeBookLiterature, $AddBook);
        //Сохраняем добавленную информацию в сессиию
        Session::save();
        return;
    }

    //Удаление литературы из сессии
    public function deleteBookInCreatingLocalLibraryReport($id, $view)
    {
        $Literature = Session::get('LibraryReportDiscLocal.Creating.Literature');
        if ($Literature['AmountOfLiterature'] > 0) {
            echo "1-";
            //Удаляем печатную литературу из справки
            if (($view) == "t") {
                //Получаем количество печатной литературы
                if (isset($Literature['AmountOftBookLiterature'])) {
                    if ($Literature['AmountOftBookLiterature'] > 0) {
                        $Memory = $Literature['tBook'][$id]['Memory'];
                        echo "2-";
                        if ($Memory == 0) {
                            if (isset($Literature['AmountOfBaseLiterature'])) {
                                echo "3-";
                                if ($Literature['AmountOfBaseLiterature'] > 0) {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOftBookLiterature']; $i++) {
                                        $Literature['tBook'][$i] = $Literature['tBook'][$i + 1];
                                    }
                                    unset($Literature['tBook'][$Literature['AmountOftBookLiterature']]);
                                    $Literature['AmountOfBaseLiterature'] = $Literature['AmountOfBaseLiterature'] - 1;
                                    $Literature['AmountOftBookLiterature'] = $Literature['AmountOftBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOftBookLiterature']; $i++) {
                                        $Literature['tBook'][$i] = $Literature['tBook'][$i + 1];
                                    }
                                    unset($Literature['tBook'][$Literature['AmountOftBookLiterature']]);
                                    unset($Literature['AmountOfBaseLiterature']);
                                    $Literature['AmountOftBookLiterature'] = $Literature['AmountOftBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        } else {
                            if (isset($Literature['AmountOfDLCLiterature'])) {
                                if ($Literature['AmountOfDLCLiterature'] > 0) {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOftBookLiterature']; $i++) {
                                        $Literature['tBook'][$i] = $Literature['tBook'][$i + 1];
                                    }
                                    unset($Literature['tBook'][$Literature['AmountOftBookLiterature']]);
                                    $Literature['AmountOfDLCLiterature'] = $Literature['AmountOfDLCLiterature'] - 1;
                                    $Literature['AmountOftBookLiterature'] = $Literature['AmountOftBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOftBookLiterature']; $i++) {
                                        $Literature['tBook'][$i] = $Literature['tBook'][$i + 1];
                                    }
                                    unset($Literature['tBook'][$Literature['AmountOftBookLiterature']]);
                                    unset($Literature['AmountOfDLCLiterature']);
                                    $Literature['AmountOftBookLiterature'] = $Literature['AmountOftBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        }
                    } else {
                        $Memory = $Literature['tBook'][$id]['Memory'];
                        if ($Memory == 0) {
                            if (isset($Literature['AmountOfBaseLiterature'])) {
                                if ($Literature['AmountOfBaseLiterature'] > 0) {
                                    $Literature['AmountOfBaseLiterature'] = $Literature['AmountOfBaseLiterature'] - 1;
                                    unset($Literature['AmountOftBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['tBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    unset($Literature['AmountOfBaseLiterature']);
                                    unset($Literature['AmountOftBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['tBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        } else {
                            if (isset($Literature['AmountOfDLCLiterature'])) {
                                if ($Literature['AmountOfDLCLiterature'] > 0) {
                                    $Literature['AmountOfDLCLiterature'] = $Literature['AmountOfDLCLiterature'] - 1;
                                    unset($Literature['AmountOftBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['tBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    unset($Literature['AmountOfDLCLiterature']);
                                    unset($Literature['AmountOftBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['tBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        }
                    }
                }
            } else if (($view) == "e") {
                //Получаем количество 'электронной литературы
                if (isset($Literature['AmountOfeBookLiterature'])) {
                    if ($Literature['AmountOfeBookLiterature'] > 0) {
                        $Memory = $Literature['eBook'][$id]['Memory'];
                        if ($Memory == 0) {
                            if (isset($Literature['AmountOfBaseLiterature'])) {
                                if ($Literature['AmountOfBaseLiterature'] > 0) {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOfeBookLiterature']; $i++) {
                                        $Literature['eBook'][$i] = $Literature['eBook'][$i + 1];
                                    }
                                    unset($Literature['eBook'][$Literature['AmountOftBookLiterature']]);
                                    $Literature['AmountOfBaseLiterature'] = $Literature['AmountOfBaseLiterature'] - 1;
                                    $Literature['AmountOfeBookLiterature'] = $Literature['AmountOfeBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOfeBookLiterature']; $i++) {
                                        $Literature['eBook'][$i] = $Literature['eBook'][$i + 1];
                                    }
                                    unset($Literature['eBook'][$Literature['AmountOftBookLiterature']]);
                                    unset($Literature['AmountOfBaseLiterature']);
                                    $Literature['AmountOfeBookLiterature'] = $Literature['AmountOfeBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        } else {
                            if (isset($Literature['AmountOfDLCLiterature'])) {
                                if ($Literature['AmountOfDLCLiterature'] > 0) {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOfeBookLiterature']; $i++) {
                                        $Literature['eBook'][$i] = $Literature['eBook'][$i + 1];
                                    }
                                    unset($Literature['eBook'][$Literature['AmountOftBookLiterature']]);
                                    $Literature['AmountOfDLCLiterature'] = $Literature['AmountOfDLCLiterature'] - 1;
                                    $Literature['AmountOfeBookLiterature'] = $Literature['AmountOfeBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    //Циклом cдвигаем массив и удаляем последний элемент
                                    for ($i = $id; $i < $Literature['AmountOfeBookLiterature']; $i++) {
                                        $Literature['eBook'][$i] = $Literature['eBook'][$i + 1];
                                    }
                                    unset($Literature['eBook'][$Literature['AmountOftBookLiterature']]);
                                    unset($Literature['AmountOfDLCLiterature']);
                                    $Literature['AmountOfeBookLiterature'] = $Literature['AmountOfeBookLiterature'] - 1;
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        }
                    } else {
                        $Memory = $Literature['eBook'][$id]['Memory'];
                        if ($Memory == 0) {
                            if (isset($Literature['AmountOfBaseLiterature'])) {
                                if ($Literature['AmountOfBaseLiterature'] > 0) {
                                    $Literature['AmountOfBaseLiterature'] = $Literature['AmountOfBaseLiterature'] - 1;
                                    unset($Literature['AmountOfeBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['eBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    unset($Literature['AmountOfBaseLiterature']);
                                    unset($Literature['AmountOfeBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['eBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        } else {
                            if (isset($Literature['AmountOfDLCLiterature'])) {
                                if ($Literature['AmountOfDLCLiterature'] > 0) {
                                    $Literature['AmountOfDLCLiterature'] = $Literature['AmountOfDLCLiterature'] - 1;
                                    unset($Literature['AmountOfeBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['eBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                } else {
                                    unset($Literature['AmountOfDLCLiterature']);
                                    unset($Literature['AmountOfeBookLiterature']);
                                    $Literature['AmountOfLiterature'] = $Literature['AmountOfLiterature'] - 1;
                                    unset($Literature['eBook']);
                                    Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
                                }
                            }
                        }
                    }
                }
            }
        } else {
            Session::forget('LibraryReportDiscLocal.Creating.Literature');
        }
        Session::save();
        return;
    }

    //Получение составленной БС для редактирования
    public function getLibraryReportForEdit($year, $specialitycode, $disciplinecode)
    {
        $LibraryReport = DB::table('MY_LR_DISC')
            ->select(['*'])
            ->where('YEARED', '=', $year)
            ->where('SPECIALITYCODE', '=', $specialitycode)
            //Убрать комментарий если можно будет редактировать БС только составителю
            //->where('COMPILER', '=', (Session::get('Authenticate.name')))
            ->where('DISCIPLINECODE', '=', $disciplinecode)
            //->where('STATUS', '=', 8)
            ->get(['*']);
        if ($LibraryReport != false) {
            $LibraryReportInfo = [
                'Yeared' => $LibraryReport[0]->yeared,
                'Yeareds' => $LibraryReport[0]->yeareds,
                'SpecialityCode' => $LibraryReport[0]->specialitycode,
                'Speciality' => $LibraryReport[0]->speciality,
                'DisciplineCode' => $LibraryReport[0]->disciplinecode,
                'Discipline' => $LibraryReport[0]->discipline,
                'Compiler' => $LibraryReport[0]->compiler,
                'CreateDate' => $LibraryReport[0]->createdate,
                'UpdateDate' => $LibraryReport[0]->updatedate,
                'Fgos' => $LibraryReport[0]->fgos,
            ];
            $Literature = (unserialize(gzuncompress($LibraryReport[0]->literature)));
            $Activity = (unserialize(gzuncompress($LibraryReport[0]->activity)));
            Session::put('LibraryReportDiscLocal.Creating.Info', $LibraryReportInfo);
            Session::put('LibraryReportDiscLocal.Creating.Literature', $Literature);
            Session::put('LibraryReportDiscLocal.Creating.Activity', $Activity);
            Session::put('LibraryReportDiscLocal.Edit', 1);
            Session::save();
            return $LibraryReport;
        } else {
            return false;
        }
    }
}