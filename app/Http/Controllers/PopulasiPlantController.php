<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiPlantController extends Controller
{
    public function index()
    {
        // $data = collect(DB::select(
        //     DB::raw("
        //         SELECT A.*, B.*
        //         FROM plant_populasi A
        //         JOIN (SELECT nom_unit,hm,km,tgl,kodesite FROM plant_hm) B
        //         ON A.nom_unit = B.nom_unit
        //     "))
        // )
        // ->when(request()->site, function($data){
        //     $data = $data->where('kodesite', '=', request()->site);
        // });

        // dd($data);

        $data = DB::table('plant_populasi')->select()
        ->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')
        ->when(request()->site, function($data){
            $data = $data->where('plant_hm.kodesite', '=', request()->site);
        })
        ->when(request()->jenisTipe, function($data){
            $data = $data->where('plant_populasi.model', '=', request()->jenisTipe);
        })
        ->when(request()->jenisBrand, function($data){
            $data = $data->where('plant_populasi.engine_brand', '=', request()->jenisBrand);
        })
        ->when(request()->nama, function($data){
            $data = $data->where('plant_populasi.nom_unit', 'like', '%'.request()->nama.'%');
        })   
        ->paginate(50);

        // dd($data);

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
                DISTINCT model
                FROM plant_populasi
            ")
        ));

        $jenisBrand = collect(DB::select(
            DB::raw("
                SELECT 
                DISTINCT IF(ENGINE_BRAND='','Tidak Ada Brand', engine_brand) AS brand
                FROM plant_populasi
                ORDER BY brand
            ")
        ));

        // dd($jenisBrand);

        return view('plant.index', compact('data', 'site', 'jenisTipe', 'jenisBrand'));
    }
}
