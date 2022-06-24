@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Populasi Unit
        </h2>

        <form action="{{route('plant.index')}}" method="GET" class="grid grid-cols-4 gap-4">
            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Bulan</option>
                @for ($x=1; $x<=12; $x++) <option value="{{$x}}">{{ date('F', mktime(0,0,0, $x, 1)) }}</option>
                    @endfor
            </select>
            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Tahun</option>
                @for ($y=0; $y<count($tahun); $y++) <option value="{{$tahun[$y]}}">{{$tahun[$y]}}</option>
                    @endfor
            </select>

            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Site</option>
                @foreach ($site as $st)
                <option value="{{$st->kodesite}}">{{$st->namasite}} - {{$st->lokasi}}</option>
                @endforeach
            </select>
            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Jenis/Type</option>
                @foreach ($jenis as $jns)
                <option value="{{$jns}}">{{$jns}}</option>
                @endforeach
            </select>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap border">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r">No Unit</th>
                            <th colspan="4" class="px-4 py-3 text-center border-none">Jam Unit</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">WH</th>
                            <th class="px-4 py-3 border">BD</th>
                            <th class="px-4 py-3 border">STB</th>
                            <th class="px-4 py-3 border">MOHH</th>
                        </tr>

                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @for($i=0; $i<count($data); $i++) <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{(($data->currentPage()-1) * $data->perPage()) + ($i+1)}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$data[$i]->NOM_UNIT}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{number_format($data[$i]->WH, 1)}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{number_format($data[$i]->BD, 1)}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{number_format($data[$i]->STB, 1)}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{number_format($data[$i]->MOHH, 0)}}
                            </td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800 border">
                <span class="flex items-center col-span-3">
                    Showing {{$data->currentPage() * $data->perPage()}}-{{($data->currentPage() * $data->perPage())+$data->perPage()}} of {{$data->total()}}
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                        <ul class="inline-flex items-center">
                            <li>
                                <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                    {{$data->links()}}
                                </button>
                            </li>
                        </ul>
                    </nav>
                </span>
            </div>
        </div>


</main>
@endsection