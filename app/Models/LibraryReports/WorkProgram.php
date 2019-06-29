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

    // Метод получения формы обучения по годам набора и направлению обучения
    public function getForms($speciality, $year)
    {
        return (json_encode(
            DB::table('V_RPD_DISC')
                ->where('FSPECIALITYCODE', trim((explode(" | ", $speciality))[0]))
                ->where('FYEARED', $year)
                ->distinct()
                ->get(['FORMA'])
        ));
    }

    // Метод получения направлений по годам набора
    public function getDisciplines($speciality, $year, $forma)
    {
        //Запрос без учета уже составленных БС
        $QUERY = ("SELECT DISTINCT DISCIPLINE, DISCODE FROM V_RPD_DISC WHERE (FSPECIALITYCODE = '".trim((explode(" | ", $speciality))[0])."') AND (FYEARED = '".$year."') AND (FORMA = '".trim($forma)."') 
        AND DISCIPLINE NOT IN ( SELECT DISCIPLINE FROM MY_LR_DISC WHERE (SPECIALITYCODE = '".trim((explode(" | ", $speciality))[0])."') AND (YEARED = '".$year."') AND (STATUS = '10')) ORDER BY DISCIPLINE");
        return (json_encode(DB::select($QUERY)));
    }

    // Метод получения формы обучения по годам набора и направлению обучения
    public function getSemesters($speciality, $year, $forma, $discipline)
    {
        return (json_encode(
            DB::table('V_RPD_DISC')
                ->where('FSPECIALITYCODE', trim((explode(" | ", $speciality))[0]))
                ->where('DISCODE', trim((explode(" | ", $discipline))[0]))
                ->where('FYEARED', trim($year))
                ->where('FORMA', trim($forma))
                ->distinct()
                ->orderBy('FSEMESTER')
                ->get(['FSEMESTER'])
        ));
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
