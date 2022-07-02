<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TPController extends Controller
{
    public function index()
    {
        $data = DB::table('pmatp')->select(DB::raw("nom_unit,
        SUM(IF(AKTIVITAS='001',JAM,0)) AS OB,
        SUM(IF(AKTIVITAS='002',JAM,0)) AS ROOM,
        SUM(IF(AKTIVITAS='004',JAM,0)) AS POR,
        SUM(IF(AKTIVITAS='015',JAM,0)) AS TRAV,
        SUM(IF(AKTIVITAS='020',JAM,0)) AS GEN,
        SUM(IF(AKTIVITAS='023',JAM,0)) AS RENT,
        SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) AS TOTAL,
        SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)) AS BD,
        SUM(IF(AKTIVITAS='SOO',JAM,0)) AS S00,
        SUM(IF(AKTIVITAS='SO1',JAM,0)) AS S01,
        SUM(IF(AKTIVITAS='SO2',JAM,0)) AS S02,
        SUM(IF(AKTIVITAS='SO3',JAM,0)) AS S03,
        SUM(IF(AKTIVITAS='SO4',JAM,0)) AS S04,
        SUM(IF(AKTIVITAS='SO5',JAM,0)) AS S05,
        SUM(IF(AKTIVITAS='SO6',JAM,0)) AS S06,
        SUM(IF(AKTIVITAS='SO7',JAM,0)) AS S07,
        SUM(IF(AKTIVITAS='SO8',JAM,0)) AS S08,
        SUM(IF(AKTIVITAS='SO9',JAM,0)) AS S09,
        SUM(IF(AKTIVITAS='S10',JAM,0)) AS S10,
        SUM(IF(AKTIVITAS='S11',JAM,0)) AS S11,
        SUM(IF(AKTIVITAS='S12',JAM,0)) AS S12,
        SUM(IF(AKTIVITAS='S13',JAM,0)) AS S13,
        SUM(IF(AKTIVITAS='S14',JAM,0)) AS S14,
        SUM(IF(AKTIVITAS='S15',JAM,0)) AS S15,
        SUM(IF(AKTIVITAS='S16',JAM,0)) AS S16,
        SUM(IF(AKTIVITAS='S17',JAM,0)) AS S17,
        SUM(IF((LEFT(AKTIVITAS, 1)='S'),JAM,0)) AS STB,
        SUM(JAM) AS MOHH,
        ((SUM(JAM) - SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0))) / SUM(JAM) ) * 100 AS MA,
        (SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) / (SUM(JAM) - SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)))) * 100 AS UT"))
        ->when((request()->bulan) == null, function($data){
            $bulan = Carbon::now();
            $data = $data->whereBetween('TGL', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()]);
        })
        ->when(request()->bulan, function($data){
            $bulan = Carbon::createFromFormat('Y-m', request()->bulan);
            $data = $data->whereBetween('TGL', [$bulan->startOfMonth()->copy(), $bulan->endOfMonth()->copy()]);
        })
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site);
        })
        ->groupBy('NOM_UNIT')
        ->get();

        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));


        $data = $data->values()->paginate(request()->paginate ? request()->paginate : 50)->withQueryString();
        return view('distribusi-jam-tp.index', compact('data', 'site'));
    }
}
