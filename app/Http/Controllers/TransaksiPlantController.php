<?php

namespace App\Http\Controllers;

use App\Models\Plant_hm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiPlantController extends Controller
{
    public function index()
    {
        $unit = DB::table('plant_populasi')
        ->select(DB::raw('DISTINCT nom_unit'))
        ->orderBy('nom_unit')
        ->get();
        
        $site = DB::table('site')
        ->select()
        ->get();

        return view('plant.transaksi', compact('unit', 'site'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_unit' => 'required|max:7',
            'site' => 'required',
            'hm' => 'required',
            'km' => 'required'
        ]);

        $record = new Plant_hm;
        $record->nom_unit = $request->nom_unit;
        $record->kodesite = $request->site;
        $record->hm = $request->hm;
        $record->km = $request->km;
        $record->tgl = Carbon::now();

        $record->save();
        return redirect('/');
    }

}
