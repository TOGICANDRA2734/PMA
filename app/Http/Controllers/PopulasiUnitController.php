<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\ArrayKey;

class PopulasiUnitController extends Controller
{
    public function index(Request $request){
        // Site
        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        // Jenis / Tipe
        $jenis = DB::select(DB::raw("SELECT * FROM kode_unit"));

        // Main Data
        $data = DB::table('pmatp')
            ->select(DB::raw("NOM_UNIT,
            SUM(IF((LEFT(AKTIVITAS, 1)='0'),JAM,0)) AS WH,
            SUM(IF((AKTIVITAS = '001'), JAM, 0)) AS WHOB,
            SUM(IF((LEFT(AKTIVITAS, 1)='b'),JAM,0)) AS BD,
            SUM(IF((LEFT(AKTIVITAS, 1)='s'),JAM,0)) AS STB,
            SUM(JAM) AS MOHH,
            SUM(ritasi) AS RITASI,
            SUM(bcm) AS OB,
            SUM(distbcm)/SUM(bcm) AS DIST,
            SUM(BCM)/ SUM(IF((AKTIVITAS = '001'), JAM, 0)) AS PTY"))
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
            ->when(request()->jenis, function($data){
                $jenis = request()->jenis;
                $data = $data->whereRaw("LEFT(NOM_UNIT, 2) = '$jenis'");
            })
            ->when(request()->nama, function($data){
                $data = $data->where('NOM_UNIT', 'like', '%'.request()->nama.'%');
            })
            ->groupBy('NOM_UNIT')
            ->get();
        
        $filter = $data->toBase()
        ->map(function($value){
            $value->NOM_UNIT_2 = substr($value->NOM_UNIT,0,2);  
            return $value;
        })
        ->groupBy('NOM_UNIT_2')
        ->mapWithKeys(function($group, $key){
            return [$key => (object)[
                'WH' => $group->sum('WH'),
                'WHOB' => $group->sum('WHOB'),
                'BD' => $group->sum('BD'),
                'STB' => $group->sum('STB'),
                'MOHH' => $group->sum('MOHH'),
                'RITASI' => $group->sum('RITASI'),
                'OB' => $group->sum('OB'),
                'DIST' => $group->sum('DIST'),
                'PTY' => $group->sum('PTY'),
            ]];
        });
        
        
        if(request()->jenisTampilan == "0" || is_null(request()->jenisTampilan)){
            $data = $data->values()->paginate(request()->paginate ? request()->paginate : 50)->withQueryString();

            return view('populasi-unit-pmh.index', compact('site', 'jenis', 'data', 'filter'));
        }
        else{
            $data = $data->values();
            // dd();
        
            return view('populasi-unit-pmh.index', compact('site', 'jenis', 'data', 'filter'));
        }
        
    }
}