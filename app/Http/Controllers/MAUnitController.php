<?php

namespace App\Http\Controllers;

use App\Charts\MAChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MAUnitController extends Controller
{
    public function index()
    {

        $site = collect(DB::select(
            DB::raw("
                SELECT 
                DISTINCT B.namasite, B.kodesite, B.lokasi
                FROM plant_hm A
                JOIN (SELECT kodesite, namasite, lokasi FROM site) B
                ON A.kodesite = B.kodesite
                ORDER BY namasite
            ")
        ));

        $jenisTipe = collect(DB::select(
            DB::raw("
                SELECT 
                DISTINCT type_unit
                FROM plant_populasi
            ")
        ));

        // Pma2b
        $dataA2BNasionalTotal = DB::table('plant_populasi')->select(DB::raw("
            ((SUM(pmaa2b.jam) - SUM(IF((LEFT(pmaa2b.kode, 1)='B'),pmaa2b.jam,0))) / SUM(pmaa2b.jam) ) * 100 AS MA,
            MONTHNAME(pmaa2b.tgl) AS month_name        
        "))
        ->join('pmaa2b', 'plant_populasi.nom_unit', '=','pmaa2b.nom_unit')
        ->whereYear('pmaa2b.TGL', '=', '2022')
        ->groupBy(DB::raw('Month(pmaa2b.TGL)'))
        ->pluck('MA', 'month_name');

        $dataA2BNasionalModel = DB::table('plant_populasi')->select(DB::raw("
            plant_populasi.model,
            (SUM(pmaa2b.jam)-SUM(IF(LEFT(pmaa2b.kode,1)='B',jam,0)))/SUM(pmaa2b.jam) AS MA,
            MONTHNAME(pmaa2b.tgl) AS month_name        
        "))
        ->join('pmaa2b', 'plant_populasi.nom_unit', '=','pmaa2b.nom_unit')
        ->whereYear('pmaa2b.TGL', '=', '2022')
        ->groupBy(DB::raw('Month(pmaa2b.TGL)'), 'plant_populasi.model')
        ->get();

        // Pmatp
        $dataTP = DB::table('plant_populasi')->select(DB::raw("
            plant_populasi.nom_unit, 
            ((SUM(pmatp.jam) - SUM(IF((LEFT(pmatp.aktivitas, 1)='B'),pmatp.jam,0))) / SUM(pmatp.jam) ) * 100 AS MA,            
            MONTHNAME(pmatp.tgl) AS month_name
        "))
        ->join('pmatp', 'plant_populasi.nom_unit', '=','pmatp.nom_unit')
        ->whereYear('pmatp.TGL', '=', '2022')
        ->groupBy(DB::raw('Month(pmatp.TGL)'))
        ->pluck('MA', 'month_name');

        $dataTPModel = DB::table('plant_populasi')->select(DB::raw("
            plant_populasi.model,
            (SUM(pmatp.jam)-SUM(IF(LEFT(pmatp.aktivitas,1)='B',jam,0)))/SUM(pmatp.jam) AS MA,
            MONTHNAME(pmatp.tgl) AS month_name        
        "))
        ->join('pmatp', 'plant_populasi.nom_unit', '=','pmatp.nom_unit')
        ->whereYear('pmatp.TGL', '=', '2022')
        ->groupBy(DB::raw('Month(pmatp.TGL)'))
        ->groupBy('plant_populasi.model')
        ->get();

        $dataModel = $dataA2BNasionalModel->merge($dataTPModel);

        // Sum per Month
        foreach($dataA2BNasionalTotal as $key => $dataA2BTotal){
            $totalMA[] = ($dataA2BTotal + $dataTP[$key])/2;
        }

        $userChart = new MAChart;
        $userChart->labels($dataTP->keys());
        $userChart->dataset('Total Nasional', 'bar', $totalMA)->backgroundColor('green');
        return view('plant.ma', compact('userChart', 'site', 'jenisTipe'));
    }
}
