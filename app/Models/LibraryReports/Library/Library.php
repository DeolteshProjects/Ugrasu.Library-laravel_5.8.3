<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 30.05.2019
 * Time: 22:21
 */

namespace App\Models\LibraryReports\Library;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Library extends Model
{
    public function getAllNew()
    {
        return (
        DB::table('MY_LR_DISC')
            ->where('STATUS', 0)
            ->orWhere('STATUS', 2)
            ->distinct()
            ->orderBy('SPECIALITY')
            ->orderBy('DISCIPLINE')
            ->orderByDesc('CREATEDATE')
            ->get(['YEARED', 'YEAREDS', 'SPECIALITYCODE', 'SPECIALITY', 'DISCIPLINECODE', 'DISCIPLINE', 'FGOS', 'COMPILER', 'CREATEDATE', 'UPDATEDATE', 'STATUS'])
        );
    }

    public function getAllSuccess()
    {
        return (
        DB::table('MY_LR_DISC')
            ->where('STATUS', 10)
            ->distinct()
            ->orderBy('SPECIALITY')
            ->orderBy('DISCIPLINE')
            ->orderByDesc('CREATEDATE')
            ->get(['YEARED', 'YEAREDS', 'SPECIALITYCODE', 'SPECIALITY', 'DISCIPLINECODE', 'DISCIPLINE', 'FGOS', 'COMPILER', 'CREATEDATE', 'UPDATEDATE', 'STATUS'])
        );
    }

    public function getAllDanger()
    {
        return (
        DB::table('MY_LR_DISC')
            ->where('STATUS', 8)
            ->distinct()
            ->orderBy('SPECIALITY')
            ->orderBy('DISCIPLINE')
            ->orderByDesc('CREATEDATE')
            ->get(['YEARED', 'YEAREDS', 'SPECIALITYCODE', 'SPECIALITY', 'DISCIPLINECODE', 'DISCIPLINE', 'FGOS', 'COMPILER', 'CREATEDATE', 'UPDATEDATE', 'STATUS'])
        );
    }

    public function getAll()
    {
        return (
        DB::table('MY_LR_DISC')
            ->orderBy('SPECIALITY')
            ->orderBy('DISCIPLINE')
            ->orderByDesc('CREATEDATE')
            ->get(['YEARED', 'YEAREDS', 'SPECIALITYCODE', 'SPECIALITY', 'DISCIPLINECODE', 'DISCIPLINE', 'FGOS', 'COMPILER', 'CREATEDATE', 'UPDATEDATE', 'STATUS'])
        );
    }

    public function getCompiling()
    {
        return (
        DB::select("SELECT DISTINCT YEARED, SPECIALITY, SPECIALITYCODE FROM MY_LR_DISC")
        //DB::select("SELECT DISTINCT YEARED, SPECIALITY, SPECIALITYCODE FROM MY_LR_DISC WHERE SPECIALITYCODE IN (SELECT SPECIALITYCODE FROM MY_LR_DISC WHERE (STATUS = 10))")
        );
    }

    public function getComposition($year, $specialitycode) {
        $Created = DB::select("SELECT YEARED, SPECIALITY, SPECIALITYCODE, DISCIPLINECODE, DISCIPLINE, COMPILER, STATUS, CREATEDATE FROM MY_LR_DISC WHERE YEARED='".$year."' AND SPECIALITYCODE='".$specialitycode."'");
        $None = DB::select("SELECT DISTINCT FYEARED, SPECIALITY, DISCIPLINE FROM V_RPD_DISC WHERE FSPECIALITYCODE = '".trim($specialitycode)."' AND FYEARED=".$year." AND DISCIPLINE NOT IN (SELECT DISTINCT DISCIPLINE FROM MY_LR_DISC WHERE YEARED=".$year." AND SPECIALITYCODE='".trim($specialitycode)."')");
        if (count($Created) > 0) {
            $Composition = ['Created'=>$Created, 'None'=>$None];
            return $Composition;
        } else {
            return false;
        }
    }

    public function show($year, $speciality, $discipline, $compiler, $createdate)
    {
        $LR = DB::table('MY_LR_DISC')
            ->select(['*'])
            ->where('YEARED', $year)
            ->where('SPECIALITY',$speciality)
            ->where('DISCIPLINE', $discipline )
            ->where('COMPILER', $compiler)
            ->where('CREATEDATE', $createdate)
            ->distinct()
            ->get();
        if (!empty($LR[0])) {
            $Books = (unserialize(gzuncompress($LR[0]->literature)));
            ($LR[0]->activity !== NULL) ? $Activity = (unserialize(gzuncompress($LR[0]->activity))) : $Activity = NULL;
            $Answer = [
                'LibraryReport' => [
                    'Yeared'=>$LR[0]->yeared,
                    'Yeareds'=>$LR[0]->yeareds,
                    'SpecialityCode'=>$LR[0]->specialitycode,
                    'Speciality'=>$LR[0]->speciality,
                    'DisciplineCode'=>$LR[0]->disciplinecode,
                    'Discipline'=>$LR[0]->discipline,
                    'Fgos'=>$LR[0]->fgos,
                    'Compiler' => $LR[0]->compiler,
                    'CreateDate' => $LR[0]->createdate,
                    'Status' => $LR[0]->status,
                    'UpdateDate' => $LR[0]->updatedate,
                    'Activity' => $Activity
                ],
                //Общее число книг в справке
                'AmountOfLiterature' => $Books['AmountOfLiterature']+1,
                //Число печатных изданий
                'AmountOftBookLiterature' => (isset($Books['AmountOftBookLiterature'])) ? $Books['AmountOftBookLiterature']+1 : 0,
                //Печатные издания
                'tBook' => (isset($Books['tBook'])) ? $Books['tBook'] : NULL,
                //Число электронный изданий
                'AmountOfeBookLiterature' => (isset($Books['AmountOfeBookLiterature'])) ? $Books['AmountOfeBookLiterature']+1 : 0,
                //Электронные издания
                'eBook' => (isset($Books['eBook'])) ? $Books['eBook'] : NULL,
                //Активности справки
                'Activity' => $Activity
            ];
            return $Answer;
        } else return redirect(route('home'));
    }

    public function updateStatus($update) {
        $LR = DB::table('MY_LR_DISC')
            ->select(['ACTIVITY'])
            ->where('YEARED', $update['Year'])
            ->where('SPECIALITYCODE',$update['SpecialityCode'])
            ->where('DISCIPLINECODE', $update['DisciplineCode'] )
            ->where('COMPILER', $update['Compiler'])
            ->where('CREATEDATE', $update['CreateDate'])
            ->distinct()
            ->get();
            if ($LR[0]->activity !== NULL) {
                $Activity = (unserialize(gzuncompress($LR[0]->activity)));
                $Activity[count($Activity)] = ['ActivityDate' => date('Y-m-d H:i:s'), 'ActivityPerson' => Session::get('Authenticate.name'), 'ActivityStatus' => $update['Status'], 'ActivityComment'=> $update['Comment']];
            } else {
                $Activity[0] = ['ActivityDate' => date('Y-m-d H:i:s'), 'ActivityPerson' => Session::get('Authenticate.name'), 'ActivityStatus' => $update['Status'], 'ActivityComment'=> $update['Comment']];
            }
            //Сжимаем массив активности
        $Activity = gzcompress(((serialize($Activity))),9);
        DB::table('MY_LR_DISC')
            ->where('YEARED', $update['Year'])
            ->where('SPECIALITYCODE',$update['SpecialityCode'])
            ->where('DISCIPLINECODE', $update['DisciplineCode'] )
            ->where('COMPILER', $update['Compiler'])
            ->where('CREATEDATE', $update['CreateDate'])
            ->update(['STATUS' => $update['Status'], 'UPDATEDATE' => date('Y-m-d H:i:s'), 'ACTIVITY' => $Activity]);
        return;
    }
}