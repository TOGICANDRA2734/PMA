@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Distribusi Jam PMA2B
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-4 gap-4">
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
                <label class="font-bold pb-1 text-sm" for="jenisTampilan">Tampilan</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="jenisTampilan" id="jenisTampilan">
                    <option value="0" selected>Tampilkan Per Halaman</option>
                    <option value="1">Tampilkan Semua Halaman</option>
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
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone sticky left-0 bg-stone-800">No Unit</th>
                            <th colspan="6" class="px-4 py-3 text-center border-r">Loading</th>
                            <th colspan="14" class="px-4 py-3 text-center border-r">Working Hours</th>
                            <th colspan="19" class="px-4 py-3 text-center border-none">Status Standby</th>
                            <th rowspan="2" class="px-4 py-3 border">WH</th>
                            <th rowspan="2" class="px-4 py-3 border">UT</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">lr</th>
                            <th class="px-4 py-3 border">ll</th>
                            <th class="px-4 py-3 border">ls</th>
                            <th class="px-4 py-3 border">lb</th>
                            <th class="px-4 py-3 border">lm</th>
                            <th class="px-4 py-3 border">coal</th>
                            <th class="px-4 py-3 border">rip</th>
                            <th class="px-4 py-3 border">doz</th>
                            <th class="px-4 py-3 border">ripdoz</th>
                            <th class="px-4 py-3 border">spr</th>
                            <th class="px-4 py-3 border">drill</th>
                            <th class="px-4 py-3 border">maint</th>
                            <th class="px-4 py-3 border">clean</th>
                            <th class="px-4 py-3 border">land</th>
                            <th class="px-4 py-3 border">gen</th>
                            <th class="px-4 py-3 border">trav</th>
                            <th class="px-4 py-3 border">rent</th>
                            <th class="px-4 py-3 border">totalwh</th>
                            <th class="px-4 py-3 border">bd</th>
                            <th class="px-4 py-3 border">mohh</th>
                            @for($i=0; $i<=17; $i++)
                                <th class="px-4 py-3 border">S{{$i}}</th>
                            @endfor
                            <th class="px-4 py-3 border">Total STB</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $values)
                            <tr class="group data-row text-center text-gray-700 dark:text-gray-400 ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">{{$key+1}}</td>
                                <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white sticky left-0 bg-white">{{$data[$key]->nom_unit}}</td>
                                @foreach($values as $keys => $value)
                                    @if($keys != "K_kode")
                                        @if($keys != "nom_unit")
                                            <td class="px-4 py-3 border group-hover:bg-gray-400 group-hover:text-white">
                                                {{$value}}
                                            </td>
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
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>
@endsection