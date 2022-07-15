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
                <table class="w-full whitespace-no-wrap border table-auto">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">No</th>
                            <th class="px-4 py-3 border">Nom Unit</th>
                            <th class="px-4 py-3 border">Model</th>
                            <th class="px-4 py-3 border">Type Unit</th>
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
                        @foreach($data as $key => $dt)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border">
                                    {{$key + 1}}    
                                </td>
                                @foreach($dt as $key => $values)
                                    @if($key != "pic_1")
                                        @if($key != "pic_2")
                                            @if($key != "kodesite")
                                                @if($key != "del")
                                                    @if($key != "id")
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

    <!-- Dropdown Detail -->
    <div class="bg-white p-5 rounded-md">
    <button
        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
        @click="toggleDetailPlant"
        aria-haspopup="true"
        >
        <span class="inline-flex items-center">
            <span class="">Jumlah Per Unit</span>
        </span>
        <svg
            class="w-4 h-4"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
        >
            <path
            fill-rule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clip-rule="evenodd"
            ></path>
        </svg>
        </button>
        <template x-if="isDetailPlantOpen">
            <ul
                x-transition:enter="transition-all ease-in-out duration-300"
                x-transition:enter-start="opacity-25 max-h-0"
                x-transition:enter-end="opacity-100 max-h-xl"
                x-transition:leave="transition-all ease-in-out duration-300"
                x-transition:leave-start="opacity-100 max-h-xl"
                x-transition:leave-end="opacity-0 max-h-0"
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu"
            >
                <div class="grid grid-cols-5 gap-2">
                    @foreach($summary as $data)
                        <div class="text-xs p-2 ">
                            <span class="font-semibold">{{$data->type_unit}}:</span> {{$data->TOTAL}} Unit
                        </div>
                    @endforeach
                </div>
            </ul>
        </template>


        
    </div>

    
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>
@endsection