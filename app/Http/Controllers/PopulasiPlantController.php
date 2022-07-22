<?php

namespace App\Http\Controllers;

use App\Models\Plant_populasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PopulasiPlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('plant_populasi')->select()
        ->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')
        ->join('site', 'plant_hm.kodesite', '=', 'site.kodesite')
        ->when(request()->site, function($data){
            $data = $data->where('plant_hm.kodesite', '=', request()->site);
        })
        ->when(request()->jenisTipe, function($data){
            $data = $data->where('plant_populasi.type_unit', '=', request()->jenisTipe);
        })
        ->when(request()->jenisBrand, function($data){
            $data = $data->where('plant_populasi.engine_brand', '=', request()->jenisBrand);
        })
        ->when(request()->nama, function($data){
            $data = $data->where('plant_populasi.nom_unit', 'like', '%'.request()->nama.'%');
        })   
        ->paginate(request()->paginate ? request()->paginate : 50)
        ->withQueryString();

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
                DISTINCT type_unit
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

        $summary = DB::table('plant_populasi')->select(DB::raw('DISTINCT plant_populasi.type_unit, COUNT(plant_populasi.type_unit) TOTAL'))
        ->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')
        ->when(request()->site, function($data){
            $data = $data->where('plant_hm.kodesite', '=', request()->site);
        })
        ->when(request()->jenisTipe, function($data){
            $data = $data->where('plant_populasi.type_unit', '=', request()->jenisTipe);
        })
        ->when(request()->nama, function($data){
            $data = $data->where('plant_populasi.nom_unit', 'like', '%'.request()->nama.'%');
        })   
        ->groupBy('plant_populasi.type_unit')
        ->groupBy('plant_hm.tgl')
        ->get();

        
        return view('plant.index', compact('data', 'site', 'jenisTipe', 'jenisBrand', 'summary'));
    }

    public function getUserbyid(Request $request){

        $userid = $request->userid;

        $data = DB::table('plant_populasi')->select('*')->join('plant_hm', 'plant_populasi.nom_unit', '=', 'plant_hm.nom_unit')->where('plant_hm.id', $userid)->get();

        $dataChart = DB::table('pmaa2b')->select(DB::raw("
            MONTHNAME(TGL),
            (SUM(jam)-SUM(IF(LEFT(kode,1)='B',jam,0)))/SUM(jam) AS MA
        "))
        ->where('nom_unit', '=', $data[0]->nom_unit)
        ->get();
        
        
        if(!isset($dataChart)){
            $dataChart = DB::table('pmatp')->select(DB::raw("
                MONTHNAME(TGL),
                (SUM(jam)-SUM(IF(LEFT(aktivitas,1)='B',jam,0)))/SUM(jam) AS MA
            "))
            ->where('nom_unit', '=', $data[0]->nom_unit)
            ->get();
        }

        $response['data'] = $data;
        $response['dataChart'] = $dataChart;
        
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = DB::table('plant_populasi')->distinct()->select('model')->get();
        $type_unit =  DB::table('plant_populasi')->distinct()->select('type_unit')->get();
        $engine_brand = DB::table('plant_populasi')->distinct()->select('engine_brand')->get();
        
        return view('transaksi.unit', compact('model', 'type_unit', 'engine_brand'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'pic_1' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'pic_2' => 'required|image|mimes:jpeg,jpg,png|max:2000',
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


        $record = Plant_populasi::create([
            'nom_unit'       =>  $request->nom_unit,
            'model'          =>  $request->model,
            'type_unit'      =>  $request->type_unit,
            'sn'             =>  $request->sn,
            'engine_brand'   =>  $request->engine_brand,
            'engine_sn'      =>  $request->engine_sn,
            'engine_model'   =>  $request->engine_model,
            'hp'             =>  $request->hp,
            'DO'             =>  Carbon::now(),
            'height'         =>  $request->height,
            'width'          =>  $request->width,
            'length'         =>  $request->length,
            'fuel'           =>  $request->fuel,
            'pic_1'          =>  $pic_1->hashName(),
            'pic_2'          =>  $pic_2->hashName(),
            'fuel'           =>  1,
        ]);

        if($record){
            return redirect()->route('populasi-plant.index')->with(['success' => 'Data berhasil disimpan']);
        }
        else{
            return redirect()->route('populasi-plant.index')->with(['error' => 'Data tidak berhasil disimpan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plant = Plant_populasi::findOrFail($id);
        $model = DB::table('plant_populasi')->distinct()->select('model')->get();
        $type_unit =  DB::table('plant_populasi')->distinct()->select('type_unit')->get();
        $engine_brand = DB::table('plant_populasi')->distinct()->select('engine_brand')->get();
        
        return view('transaksi.edit', compact('model', 'type_unit', 'engine_brand', 'plant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            'pic_1' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'pic_2' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'height' => 'required',
            'width' => 'required',
            'length' => 'required',
            'fuel' => 'required',
        ]);

        $record = Plant_populasi::findOrFail($id);

        // Check Image
        if($request->file('pic_1') == '' && $request->file('pic_2') == ''){
            $record->update([
                'nom_unit'       =>  $request->nom_unit,
                'model'          =>  $request->model,
                'type_unit'      =>  $request->type_unit,
                'sn'             =>  $request->sn,
                'engine_brand'   =>  $request->engine_brand,
                'engine_sn'      =>  $request->engine_sn,
                'engine_model'   =>  $request->engine_model,
                'hp'             =>  $request->hp,
                'DO'             =>  Carbon::now(),
                'height'         =>  $request->height,
                'width'          =>  $request->width,
                'length'         =>  $request->length,
                'fuel'           =>  $request->fuel,
                'fuel'           =>  1,
            ]); 
        } else {
            if($request->file('pic_1') == ''){
                Storage::disk('local')->delete('public/plant/'.basename($record->pic_1));
                $pic_1 = $request->file('pic_1');
                $pic_1->storeAs('public/plant', $pic_1->hashName());
            }
            
            if($request->file('pic_2') == ''){
                Storage::disk('local')->delete('public/plant/'.basename($record->pic_1));
                $pic_2 = $request->file('pic_2');
                $pic_2->storeAs('public/plant', $pic_2->hashName());
            }   

            $record->update([
                'nom_unit'       =>  $request->nom_unit,
                'model'          =>  $request->model,
                'type_unit'      =>  $request->type_unit,
                'sn'             =>  $request->sn,
                'engine_brand'   =>  $request->engine_brand,
                'engine_sn'      =>  $request->engine_sn,
                'engine_model'   =>  $request->engine_model,
                'hp'             =>  $request->hp,
                'DO'             =>  Carbon::now(),
                'height'         =>  $request->height,
                'width'          =>  $request->width,
                'length'         =>  $request->length,
                'fuel'           =>  $request->fuel,
                'pic_1'          =>  $pic_1->hashName(),
                'pic_2'          =>  $pic_2->hashName(),
                'fuel'           =>  1,
            ]);
        }

        if($record){
            return redirect()->route('populasi-plant.index')->with(['success' => 'Data berhasil diperbaharui']);
        }
        else{
            return redirect()->route('populasi-plant.index')->with(['error' => 'Data tidak berhasil diperbaharui']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Plant_populasi::findOrFail($id);
        Storage::disk('local')->delete('public/plant/'.basename($record->pic_1));
        Storage::disk('local')->delete('public/plant/'.basename($record->pic_2));
        $record->delete();

        if($record){
            return response()->json([
                'status' => 'success'
            ]);
        }
        else{
            return response()->json([
                'status' => 'success'
            ]);
        }
    }
}
