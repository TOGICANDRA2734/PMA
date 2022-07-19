<?php

namespace App\Http\Controllers;

use App\Models\Plant_populasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiUnitController extends Controller
{
    public function index()
    {
        $model = DB::table('plant_populasi')->distinct()->select('model')->get();
        $type_unit =  DB::table('plant_populasi')->distinct()->select('type_unit')->get();
        $engine_brand = DB::table('plant_populasi')->distinct()->select('engine_brand')->get();
        
        return view('transaksi.unit', compact('model', 'type_unit', 'engine_brand'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_unit' => 'required',
            'model' => 'required',
            'type_unit' => 'required',
            'sn' => 'required',
            'engine_brand' => 'required',
            'engine_model' => 'required',
            'engine_sn' => 'required',
            'hp' => 'required',
            'pic_1' => 'required',
            'pic_2' => 'required',
            'height' => 'required',
            'width' => 'required',
            'length' => 'required',
            'fuel' => 'required',
        ]);

        // Gambar 
        $pic_1 = $request->file('pic_1');
        $pic_2 = $request->file('pic_2');
        $pic_1->storeAs('public/plant', $pic_1->hashName());
        $pic_2->storeAs('public/plant', $pic_2->hashName());


        $record = new Plant_populasi();
        $record->nom_unit = $request->nom_unit;
        $record->model = $request->model;
        $record->type_unit = $request->type_unit;
        $record->sn = $request->sn;
        $record->engine_brand = $request->engine_brand;
        $record->engine_sn = $request->engine_sn;
        $record->engine_model = $request->engine_model;
        $record->hp = $request->hp;
        $record->DO = Carbon::now();
        $record->height = $request->height;
        $record->width = $request->width;
        $record->length = $request->length;
        $record->fuel = $request->fuel;
        $record->pic_1 = $pic_1->hashName();
        $record->pic_2 = $pic_2->hashName();
        $record->fuel = 1;

        $record->save();

        return redirect('/');
    }

    public function edit($id)
    {
        $plant = Plant_populasi::findOrFail($id);
        $model = DB::table('plant_populasi')->distinct()->select('model')->get();
        $type_unit =  DB::table('plant_populasi')->distinct()->select('type_unit')->get();
        $engine_brand = DB::table('plant_populasi')->distinct()->select('engine_brand')->get();
        
        return view('transaksi.edit', compact('model', 'type_unit', 'engine_brand', 'plant'));
    }

    public function update(Request $request, Plant_populasi $plant)
    {
        $request->validate([
            'nom_unit' => 'required',
        ]);

        if($request->file('pic_1' == '' )|| $request->file('pic_2' == '')){
            // dd("Masuk bosku");
            $plant = Plant_populasi::findOrFail($plant->id);
            $plant->update([
                'nom_unit'          => $request->nom_unit,
                'model'             => $request->model,
                'type_unit'         => $request->type_unit,
                'sn'                => $request->sn,
                'engine_brand'      => $request->engine_brand,
                'engine_sn'         => $request->engine_sn,
                'engine_model'      => $request->engine_model,
                'hp'                => $request->hp,
                'height'            => $request->height,
                'width'             => $request->width,
                'length'            => $request->length,
                'fuel'              => $request->fuel,
            ]);
        } else {
            // dd("Gamasuk bosku");
            Storage::disk('local')->delete('public/categories/'.basename($plant->pic_1));
            Storage::disk('local')->delete('public/categories/'.basename($plant->pic_2));
            
            // Gambar 
            $pic_1 = $request->file('pic_1');
            $pic_2 = $request->file('pic_2');
            $pic_1->storeAs('public/plant', $pic_1->hashName());
            $pic_2->storeAs('public/plant', $pic_2->hashName());

            $plant = Plant_populasi::findOrFail($plant->id);
            $plant->update([
                'nom_unit'          => $request->nom_unit,
                'model'             => $request->model,
                'type_unit'         => $request->type_unit,
                'sn'                => $request->sn,
                'engine_brand'      => $request->engine_brand,
                'engine_sn'         => $request->engine_sn,
                'engine_model'      => $request->engine_model,
                'hp'                => $request->hp,
                'height'            => $request->height,
                'width'             => $request->width,
                'length'            => $request->length,
                'fuel'              => $request->fuel,
                'pic_1'              => $pic_1->hashName(),
                'pic_2'              => $pic_2->hashName(),
            ]);
        }

        return redirect();
    }

    public function destory($id){
        $data = Plant_populasi::findOrFail($id);
        Storage::disk('local')->delete('public/plant/'.basename($data->pic_1));
        Storage::disk('local')->delete('public/plant/'.basename($data->pic_2));
        $data->del = 0;

        if($data){
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
