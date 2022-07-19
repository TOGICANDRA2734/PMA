<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MAUnitController extends Controller
{
    public function index()
    {
        // Pma2b
        $dataA2B = DB::table('plant_populasi')->select(DB::raw("
            plant_populasi.nom_unit, 
            SUM(pmaa2b.jam) AS MOHH,
            SUM(IF(LEFT(pmaa2b.kode,1)='0',jam,0)) WH,
            SUM(IF(LEFT(pmaa2b.kode,1)='B',jam,0)) BD,
            ((SUM(pmaa2b.jam) - SUM(IF((LEFT(pmaa2b.kode, 1)='B'),pmaa2b.jam,0))) / SUM(pmaa2b.jam) ) * 100 AS MA,
            MONTHNAME(pmaa2b.tgl) AS month_name
        "))
        ->join('pmaa2b', 'plant_populasi.nom_unit', '=','pmaa2b.nom_unit')
        ->whereYear('pmaa2b.TGL', '=', '2022')
        ->groupBy(DB::raw('Month(pmaa2b.TGL)'))
        ->pluck('MA', 'month_name');

        // Pmatp
        $dataTP = DB::table('plant_populasi')->select(DB::raw("
            plant_populasi.nom_unit, 
            SUM(pmatp.jam) AS MOHH,
            SUM(IF(LEFT(pmatp.aktivitas,1)='0',jam,0)) WH,
            SUM(IF(LEFT(pmatp.aktivitas,1)='B',jam,0)) BD,
            ((SUM(pmatp.jam) - SUM(IF((LEFT(pmatp.aktivitas, 1)='B'),pmatp.jam,0))) / SUM(pmatp.jam) ) * 100 AS MA,            
            MONTHNAME(pmatp.tgl) AS month_name

        "))
        ->join('pmatp', 'plant_populasi.nom_unit', '=','pmatp.nom_unit')
        ->whereYear('pmatp.TGL', '=', '2022')
        ->groupBy(DB::raw('Month(pmatp.TGL)'))
        ->pluck('MA', 'month_name');

        $data[0] = $dataA2B;
        $data[1] = $dataTP;

        // dd($data);

        return view('plant.ma', compact('data'));
    }
}
