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
                <label fo class="font-bold pb-1 text-sm" for="site">Nama Site</label>
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
                        <option value="{{$jt->type_unit}}" {{old('jenisTipe', request()->jenisTipe) == $jt->type_unit ? 'selected' : ''}}>{{$jt->type_unit}}</option>
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
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border">No</th>
                            <th rowspan="2" class="px-4 py-3 border sticky left-0 bg-stone-800 z-20">Nom Unit</th>
                            <th rowspan="2" class="px-4 py-3 border">Model</th>
                            <th rowspan="2" class="px-4 py-3 border">Type Unit</th>
                            <th rowspan="2" class="px-4 py-3 border">S/N</th>
                            <th colspan="3" class="px-4 py-3 border">Engine</th>
                            <th rowspan="2" class="px-4 py-3 border">HP</th>
                            <th rowspan="2" class="px-4 py-3 border">Fuel</th>
                            <th rowspan="2" class="px-4 py-3 border">WH</th>
                            <th rowspan="2" class="px-4 py-3 border">KM</th>
                            <th rowspan="2" class="px-4 py-3 border">Site</th>
                            <th rowspan="2" class="px-4 py-3 border">Aksi</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">Brand</th>
                            <th class="px-4 py-3 border">Model</th>
                            <th class="px-4 py-3 border">SN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $dt)
                            <tr class="group data-row text-center text-gray-700 dark:text-gray-400 ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                    {{$key + 1}}    
                                </td>
                                <td class="px-4 py-3 text-sm sticky left-0 bg-white group-hover:bg-gray-400 group-hover:text-white">
                                    {{$data[$key]->nom_unit}}    
                                </td>
                                @foreach($dt as $key => $values)
                                    @if($key != "pic_1")
                                        @if($key != "pic_2")
                                            @if($key != "del")
                                                @if($key != "id")
                                                    @if($key != "nom_unit")
                                                        @if($key != "DO")
                                                            @if($key != "height")
                                                                @if($key != "width")
                                                                    @if($key != 'tgl')
                                                                        @if($key != "length")
                                                                            @if($key != "lokasi")
                                                                                @if($key != "lokasi")
                                                                                    @if($key != "kepanjangan")
                                                                                        @if($key != "kodesite")
                                                                                            @if($key != "status")
                                                                                                @if(false === strtotime($values))
                                                                                                    <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                                                                        @if(is_double($values))
                                                                                                            {{number_format($values, 0, ',', '.')}}
                                                                                                        @else
                                                                                                            {{$values}}
                                                                                                        @endif    
                                                                                                    </td>
                                                                                                @else
                                                                                                    @if ($key == 'sn' or $key == 'engine_brand' or $key == 'id' or $key == 'namasite')
                                                                                                        <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                                                                            {{$values}}
                                                                                                        </td>
                                                                                                    @else
                                                                                                        <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
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
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                <td class="px-4 py-3 text-sm group-hover:bg-gray-400 group-hover:text-white flex ">
                                    <button @click="openModal2" value="{{$dt->id}}" class="tbDetail px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-stone-800 border border-transparent rounded-md active:bg-stone-800 hover:bg-stone-900 focus:outline-none focus:shadow-outline-purple">
                                        ...
                                    </button>
                                    <!-- <a href="{{route('transaksi-unit.edit', ['id' => $dt->id])}}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-900 focus:outline-none focus:shadow-outline-purple">
                                        <i class="fa-solid fa-pencil"></i>
                                    </a>
                                    <button onClick="destroy(this.id)" id="{{ $dt->id }}" class="px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-500 border border-transparent rounded-md active:bg-red-600 hover:bg-red-900 focus:outline-none focus:shadow-outline-purple">
                                        <i class="fa-solid fa-trash"></i>
                                    </button> -->
                                </td>
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
<script src="https://unpkg.com/vue"></script>
<script>
    var app = new Vue({
        el: '#app',
    });
</script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
@endsection

@section('javascripts')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    $(document).ready(function(){
        // Search by userid
        $('.tbDetail').click(function(){
            var userid = $(this).val();

            if(userid >= 0 ){
                // AJAX POST request
                $.ajax({
                    url: '{{ route("populasi-plant.showUser") }}',
                    type: 'post',
                    data: {_token: CSRF_TOKEN, userid: userid},
                    dataType: 'json',
                    success: function(response){
                        createRows(response);
                        console.log(response);
                    }
                });
            }
        });
   });
 
   // Create table rows
    function createRows(response){
        var len = 0;
        $('#tableUnit tbody').empty(); // Empty <tbody>
        $('#imageUnit').empty(); // Empty <tbody>
        if(response['data'] != null){
            len = response['data'].length;
        }

        if(len > 0){
            var image = 
            "<img class='rounded-md pb-3 w-full' src='https://images.unsplash.com/photo-1622645636770-11fbf0611463?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1473&q=80' alt=''/>" +
            "<img class='rounded-md pb-3 w-full' src='https://images.unsplash.com/photo-1622645636770-11fbf0611463?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1473&q=80' alt=''/>" ;
            $("#imageUnit").append(image);

            var tr_str = 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-2 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>NOM UNIT</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].nom_unit + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-2 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>DO</th>" + 
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + dateConverter(response['data'][0].DO)  + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-2 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Height</th>" + 
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].height + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Width</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].width + "</td>" + 
                    "</tr>" + 
                    "<tr class='data-row text-center text-gray-700 dark:text-gray-400'>"+
                        "<th class='px-1 py-1 md:px-4 md:py-3 border-b border-r text-xs bg-stone-800 text-white'>Length</th>" +
                        "<td class='px-2 py-2 md:px-4 md:py-3 text-xs md:text-sm'>" + response['data'][0].length + "</td>" + 
                    "</tr>";
                $("#tableUnit tbody").append(tr_str);
        }else{
            var tr_str = "<tr>" +
            "<td align='center' colspan='"+ response['data'][0][value].length +"'>No record found.</td>" +
            "</tr>";
    
            $("#tableUnit tbody").append(tr_str);
        }
    }
    
    function dateConverter($value){
        var date = $value.split('-');
        return date[2] + '-' + date[1] + '-' + date[0];
    }

    function monthDifference(d1, d2){
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth();
        months += d2.getMonth();
        return months;
    }
</script>
@endsection

@section('modal-body')
    <div id="dataModal" class="">
        <h2 class="font-bold text-xl mb-3">Data Detail Unit</h2>
        <hr class="border w-full px-3">
    </div>
    
    <!-- Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="overflow-y-auto max-h-[30rem]">
            <div class="w-full overflow-y-auto sm:max-h-[20rem] mt-3 mb-3">
                <h2 class="font-bold mb-2">Data Unit</h2>
                <div class="grid grid-cols-1 gap-5">
                </div>
                <div id="imageUnit" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                </div>

                <table id='tableUnit' class="w-full whitespace-no-wrap border table-auto">
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection