<?php

namespace App\Models\LibraryReports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkProgram extends Model
{
    // Метод получения направлений по годам набора
    public function getSpeciality($year)
    {
        return (json_encode(
            DB::table("V_RPD_DISC")
                ->where('FYEARED', $year)
                ->distinct()
                ->get(['SPECIALITY', 'FSPECIALITYCODE'])
        ));
    }

    // Метод получения направлений по годам набора
    public function getDisciplines($speciality, $year)
    {
        //Запрос без учета уже составленных БС
        $QUERY = ("SELECT DISTINCT DISCIPLINE, DISCODE FROM V_RPD_DISC WHERE (FSPECIALITYCODE = '".trim((explode(" | ", $speciality))[0])."') AND (FYEARED = '".$year."') 
        AND DISCIPLINE NOT IN ( SELECT DISTINCT DISCIPLINE FROM MY_LR_DISC WHERE (SPECIALITYCODE = '".trim((explode(" | ", $speciality))[0])."') AND (YEARED = '".$year."') AND (STATUS = '10')) ORDER BY DISCIPLINE");
        return (json_encode(DB::select($QUERY)));

        //Обычный запрос
        /*
        return (json_encode(
            DB::table('V_RPD_DISC')
                ->where('FSPECIALITYCODE', trim((explode(" | ", $speciality))[0]))
                ->where('FYEARED', $year)
                ->distinct()
                ->get(['DISCIPLINE', 'DISCODE'])
        ));
        */
    }

    // Метод получения направлений по годам набора
    public function getFGOS($speciality)
    {
        return (json_encode(
            DB::table('RPD_FGOS')
                ->where('FSPECIALITYCODE', trim((explode(" | ", $speciality))[0]))
                ->get(['FGOS3_P', 'FGOS3_PP'])
        ));
    }
}
