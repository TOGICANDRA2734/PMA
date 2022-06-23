<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PopulasiUnitController extends Controller
{
    public function index(){
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
        $jenis = DB::table('pmatp')->select(DB::raw('LEFT(NOM_UNIT, 2)'))->distinct()->get();
        // dd($jenis[0].str("LEFT(NOM_UNIT, 2)"));
        
        return view('plant.index', compact('tahun', 'site', 'jenis'));
    }
}
