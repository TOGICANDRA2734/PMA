@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Populasi Plant
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-4 gap-4">
            <!-- Site -->
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
                <label class="font-bold pb-1 text-sm" for="jenisTipe">Tipe</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="jenisTipe" id="jenisTipe">
                    <option value="" selected>Semua Tipe</option>
                    
                    @foreach ($jenisTipe as $jt)
                        <option value="{{$jt->model}}" {{old('jenisTipe', request()->jenisTipe) == $jt->model ? 'selected' : ''}}>{{$jt->model}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="font-bold pb-1 text-sm" for="jenisBrand">Brand</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="jenisBrand" id="jenisBrand">
                    <option value="" selected>Semua brand</option>

                    @foreach ($jenisBrand as $jb)
                        <option value="{{$jb->brand}}" {{old('jenisBrand', request()->jenisBrand) == $jb->brand ? 'selected' : ''}}>{{$jb->brand}}</option>
                    @endforeach
                </select>
            </div>
            
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Proses</button>
        </form>

        <form class="flex justify-end mt-5" action="{{route(request()->route()->getName())}}" method="GET">
            <input name="nama" id="nama" type="text" placeholder="Cari data" class="p-2 rounded-md mr-3 w-full md:w-auto text-xs md:text-sm" autocomplete="off">
            <button class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-600 border border-transparent rounded-md active:bg-stone-600 hover:bg-stone-700 focus:outline-none focus:shadow-outline-purple">
                Cari
            </button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto"  style="max-height: 36rem;">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">No</th>
                            <th class="px-4 py-3 border">Nom Unit</th>
                            <th class="px-4 py-3 border">Model</th>
                            <th class="px-4 py-3 border">Type</th>
                            <th class="px-4 py-3 border">SN</th>
                            <th class="px-4 py-3 border">Engine Brand</th>
                            <th class="px-4 py-3 border">Engine Model</th>
                            <th class="px-4 py-3 border">Engine SN</th>
                            <th class="px-4 py-3 border">HP</th>
                            <th class="px-4 py-3 border">DO</th>
                            <th class="px-4 py-3 border">Height</th>
                            <th class="px-4 py-3 border">Width</th>
                            <th class="px-4 py-3 border">Length</th>
                            <th class="px-4 py-3 border">Fuel</th>
                            <th class="px-4 py-3 border">WH</th>
                            <th class="px-4 py-3 border">KH</th>
                            <th class="px-4 py-3 border">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $dt)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                @foreach($dt as $key => $values)
                                    @if($key != "pic_1")
                                        @if($key != "pic_2")
                                            @if($key != "kodesite")
                                                @if($key != "del")
                                                    @if(false === strtotime($values))
                                                        <td class="px-4 py-3 border">
                                                            @if(is_double($values))
                                                                {{number_format($values, 0, ',', '.')}}
                                                            @else
                                                                {{$values}}
                                                            @endif    
                                                        </td>
                                                    @else
                                                        @if ($key == 'sn' or $key == 'engine_brand' or $key == 'id')
                                                            <td class="px-4 py-3 border">
                                                                {{$values}}
                                                            </td>
                                                        @else
                                                            <td class="px-4 py-3 border">
                                                                <!-- Tanggal  -->
                                                                {{date_format(new DateTime($values), "d/m/Y")}}
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
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

    <div class="bg-white p-5">
        <div class="grid grid-cols-4 gap-5">
            @foreach($summary as $data)
                <div>
                    {{$data->tipe}} : {{$data->TOTAL}}
                </div>
            @endforeach
        </div>
    </div>
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>
@endsection