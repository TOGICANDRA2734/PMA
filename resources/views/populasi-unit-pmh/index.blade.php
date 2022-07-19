@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Produksi TP
        </h2>

        <form action="{{route('populasi-unit-pmh.index')}}" method="GET" class="grid grid-cols-5 gap-4">
            <!-- Bulan -->
            <div class="">
                <label class="font-bold pb-1 text-sm" for="bulan">Tanggal Mulai</label>
                <input value="{{ request()->bulan == null ? date('Y-m') : old('bulan', request()->bulan)}}" type="month" name="bulan" id="bulan" class="p-2 border border-gray-100 rounded-md w-full">
            </div>

            <div class="">
                <label fo class="font-bold pb-1 text-sm"r="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="site" id="site">
                    <option value="" selected>Semua Site</option>

                    @foreach ($site as $st)
                        <option value="{{$st->kodesite}}" {{old('site', request()->site) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-bold pb-1 text-sm" for="jenis">Jenis</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="jenis" id="jenis">
                    <option value="" selected >Semua Type</option>
                    @foreach ($jenis as $jns)
                        <option value="{{$jns->kode_unit}}" {{old('jenis', request()->jenis) == $jns->kode_unit ? 'selected' : ''}}>{{$jns->kode_unit}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-bold pb-1 text-sm" for="jenisTampilan">Tampilkan Total Per Unit</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="jenisTampilan" id="jenisTampilan">
                    <option value="0" selected>Jangan Tampilkan</option>
                    <option value="1">Tampilkan</option>
                </select>
            </div>
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Proses</button>
        </form>

        <form class="flex justify-end mt-5" action="{{route(request()->route()->getName())}}" method="GET">
            @foreach (request()->all() as $key => $values) 
                <input type="hidden" name="{{$key}}" id="{{$key}}" class="text-black w-7 text-xs" value="{{$values}}">
            @endforeach
            <input name="nama" id="nama" type="text" placeholder="Cari data" class="p-2 rounded-md mr-3 w-full md:w-auto text-xs md:text-sm" autocomplete="off">
            <button class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-600 border border-transparent rounded-md active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
                Cari
            </button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto max-h-96 md:max-h-[38rem]">
                <table class="w-full whitespace-no-wrap border table-auto">
                    <thead class="bg-stone-800 sticky top-0 z-20">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone sticky left-0 bg-stone-800 z-20">No Unit</th>
                            <th colspan="5" class="px-4 py-3 text-center border-r">Jam Unit</th>
                            <th colspan="4" class="px-4 py-3 text-center border-none">Produksi</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">WH Total</th>
                            <th class="px-4 py-3 border">WHOB Total</th>
                            <th class="px-4 py-3 border">BD Total</th>
                            <th class="px-4 py-3 border">STB Total</th>
                            <th class="px-4 py-3 border">MOHH Total</th>
                            <th class="px-4 py-3 border">RIT</th>
                            <th class="px-4 py-3 border">OB (BCM)</th>
                            <th class="px-4 py-3 border">DIST</th>
                            <th class="px-4 py-3 border">PTY</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $dt) 
                            <tr class="group data-row text-center text-gray-700 dark:text-gray-400 ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    @if (request()->jenisTampilan == "0")
                                        {{(($data->currentPage()-1) * $data->perPage()) + ($key+1)}}
                                    @else
                                        {{$key+1}}
                                    @endif
                                </td>
                                <td id="nom_unit" class="px-4 py-3 text-sm sticky left-0 bg-white group-hover:bg-gray-400 group-hover:text-white">
                                    {{$dt->NOM_UNIT}}
                                </td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->WH, 1, ",", ".")}}
                                </td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->WHOB, 1, ",", ".")}}
                                </td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->BD, 1, ",", ".")}}
                                </td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->STB, 1, ",", ".")}}
                                </td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->MOHH, 0, ",", ".")}}
                                </td>
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->RITASI,1, ",", ".")}}
                                </td>
                                
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->OB,0, ",", ".")}}
                                </td>
                                
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->DIST,0, ",", ".")}}
                                </td>
                                
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                    {{number_format($dt->PTY,0, ",", ".")}}
                                </td>
                            </tr>
                            @if(request()->jenisTampilan != 0)
                                @if(isset(($data[$key + 1])))
                                    @php 
                                        $nextRow = $data[$key + 1]
                                    @endphp

                                    @if(substr($dt->NOM_UNIT,0,2) != substr($nextRow->NOM_UNIT,0,2))
                                        <tr class="data-row text-center text-gray-700 bg-gray-300 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white" colspan="2">Total Unit</td>
                                            @php
                                                $hasilFilter = $filter->filter(function($item, $key) use ($dt){
                                                    return in_array($key, [substr($dt->NOM_UNIT,0,2)]);
                                                });
                                            @endphp
                                            @foreach($hasilFilter as $ft)
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->WH, 1, ",", ".")}}
                                                </td>
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->WHOB, 1, ",", ".")}}
                                                </td>
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->BD, 1, ",", ".")}}
                                                </td>
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->STB, 1, ",", ".")}}
                                                </td>
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->MOHH, 0, ",", ".")}}
                                                </td>
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->RITASI,1, ",", ".")}}
                                                </td>
                                                
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->OB,0, ",", ".")}}
                                                </td>
                                                
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->DIST,0, ",", ".")}}
                                                </td>
                                                
                                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                    {{number_format($ft->PTY,0, ",", ".")}}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @elseif($key == count($data)-1)
                                    <tr class="data-row text-center text-gray-700 bg-gray-300 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white" colspan="2">Total Unit</td>
                                        @php
                                            $hasilFilter = $filter->filter(function($item, $key) use ($dt){
                                                return in_array($key, [substr($dt->NOM_UNIT,0,2)]);
                                            });
                                        @endphp
                                        @foreach($hasilFilter as $ft)
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->WH, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->WHOB, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->BD, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->STB, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->MOHH, 0, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->RITASI,1, ",", ".")}}
                                            </td>
                                            
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->OB,0, ",", ".")}}
                                            </td>
                                            
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->DIST,0, ",", ".")}}
                                            </td>
                                            
                                            <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white">
                                                {{number_format($ft->PTY,0, ",", ".")}}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endif                    
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(request()->jenisTampilan == 0)
                <div class="px-4 py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                    {{$data->links()}}
                </div>
            @endif
        </div>
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $('#nom_unit').removeClass('bg-white')
        $(el).addClass('bg-gray-200', 'text-white')
        $('#nom_unit').addClass('bg-gray-200', 'text-white')
    }
</script>
@endsection