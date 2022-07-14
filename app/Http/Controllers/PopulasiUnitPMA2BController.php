<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopulasiUnitPMA2BController extends Controller
{
    public function index()
    {
        if(request()->bulan){            
            $bulan = Carbon::createFromFormat('Y-m', request()->bulan);
            $tanggal = "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy(). "'";
            $tanggalKedua = "a.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy(). "'";
        } else {
            $bulan = Carbon::now();
            $tanggal =  "TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy()."'";
            $tanggalKedua =  "a.TGL BETWEEN '" . $bulan->startOfMonth()->copy() . "' AND '" . $bulan->endOfMonth()->copy()."'";
        }

        if(request()->site){
            $site = "AND  kodesite='".request()->site."'";
            $siteKedua = "AND  a.kodesite='".request()->site."'";
        } else {
            $site = '';
            $siteKedua = '';
        }

        $sql = "WITH summ AS
        (
            SELECT 
            COALESCE(A.nom_unit, '-- SUM --') nom_unit,
            SUM(IF((A.kode='008') OR
                    (A.kode='009') OR
                        (A.kode='010') OR
                        (A.kode='011') OR
                        (A.kode='012'),jam,0)) AS wh,
            SUM(IF((A.KODE = '001'), A.JAM, 0)) AS WHOB,
            SUM(IF((LEFT(A.KODE, 1)='b'),A.JAM,0)) AS BD,
            SUM(IF((LEFT(A.KODE, 1)='s'),A.JAM,0)) AS STB,
            SUM(A.JAM) AS MOHH,
            (B.prod) AS bcm,
            (B.distbcm) AS distbcm,
            (B.rit) AS rit
            FROM pmaa2b A
            JOIN (
                SELECT unit_load, 
                SUM(bcm) AS prod, 
                SUM(distbcm) distbcm, 
                SUM(ritasi) rit 
                FROM pmatp WHERE (".$tanggal.") 
                ".$site."
                GROUP BY unit_load) B
            ON A.nom_unit = B.unit_load
            WHERE (". $tanggalKedua .")
            ". $siteKedua ."
            GROUP BY nom_unit 
        )  
        SELECT *,IFNULL((bcm/wh),0) pty,(distbcm/bcm) jarak FROM summ WHERE bcm !=0 GROUP BY nom_unit ";

        // dd($sql);

        $data = collect(DB::select($sql));

        $filter = collect(DB::select($sql))
        ->toBase()
        ->map(function($value){
            $value->NOM_UNIT_2 = substr($value->nom_unit,0,2);  
            return $value;
        })
        ->groupBy('NOM_UNIT_2')
        ->mapWithKeys(function($group, $key){
            return [$key => (object)[
                'wh' => $group->sum('wh'),
                'WHOB' => $group->sum('WHOB'),
                'BD' => $group->sum('BD'),
                'STB' => $group->sum('STB'),
                'MOHH' => $group->sum('MOHH'),
                'bcm' => $group->sum('bcm'),
                'distbcm' => $group->sum('distbcm'),
                'rit' => $group->sum('rit'),
                'pty' => $group->sum('pty'),
                'jarak' => $group->sum('jarak')
            ]];
        });

        $site = collect(DB::select(DB::raw("SELECT kodesite, namasite, lokasi
        FROM SITE
        WHERE status=1
        ORDER BY namasite")));

        $data = $data->values();
        return view('pma2b.populasi.index', compact('data', 'site', 'filter'));
    }
}
