<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index(Request $request){
        // year
        $tahunMax = DB::table('pmatp')->max('TGL'); 
        $tahunMax = Carbon::createFromFormat('Y-m-d', $tahunMax)->year;
        $tahunMin = DB::table('pmatp')->min('TGL'); 
        $tahunMin = Carbon::createFromFormat('Y-m-d', $tahunMin)->year;
        $tahun = range($tahunMin, $tahunMax);
        
        // Site
        $site = DB::table('site')->get();
        // dd($site);

        // Jenis / Tipe
        $jenis = DB::table('pmatp')->select('NOM_UNIT')->distinct()->get();
        $jenis = $jenis->pluck('NOM_UNIT')->map(function($item){
            return substr($item, 0, 2);
        })->unique()->values();
        // dd($jenis);

        $data = DB::table('pmatp')
        ->select(DB::raw("NOM_UNIT,
        SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) AS WH,
        SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)) AS BD,
        SUM(IF((LEFT(AKTIVITAS, 1)='s'),JAM,0)) AS STB,
        SUM(JAM) AS MOHH"))
        ->when(request()->bulan, function($data){
            $data = $data->whereMonth('TGL', '=', request()->bulan);
        })
        ->when(request()->tahun, function($data){
            $data = $data->whereYear('TGL', '=', request()->tahun);
        })
        ->when(request()->site, function($data){
            $data = $data->where('kodesite', '=', request()->site);
        })
        ->when(request()->jenis, function($data){
            $jenis = request()->jenis;
            $data = $data->whereRaw("LEFT(NOM_UNIT, 2) = '$jenis'");
        })
        ->groupBy('NOM_UNIT')
        ->get();
        $data = $data->values()->paginate(50);

        return view('plant.index', compact('tahun', 'site', 'jenis', 'data'));
    }
}
