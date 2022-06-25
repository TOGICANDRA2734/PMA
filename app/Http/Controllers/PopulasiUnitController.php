<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index(Request $request){
        // year
        $tahunMax = DB::table('pmatp')->select('TGL')->max('TGL'); 
        $tahun = Cache::remember('tahun', 86400, function(){
            return range(2016, Carbon::createFromFormat('Y-m-d', DB::table('pmatp')->select('TGL')->max('TGL'))->year);
        });
        
        // Site
        $site = Cache::remember('site', 86400, function(){
            return DB::table('site')->select('kodesite','namasite','lokasi')->orderBy('namasite')->get();
        });

        // Jenis / Tipe
        $jenis = DB::table('pmatp')->select('NOM_UNIT')->distinct()->orderBy('NOM_UNIT')->get();
        $jenis = $jenis->pluck('NOM_UNIT')->map(function($item){
            return substr($item, 0, 2);
        })->unique()->values();

        // Main Data
        $data = Cache::remember('data', 86400, function(){
            return DB::table('pmatp')
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
        });
        $data = $data->values()->paginate(50);

        return view('plant.index', compact('tahun', 'site', 'jenis', 'data'));
    }
}
