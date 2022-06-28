@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Populasi Unit
        </h2>

        <form action="{{route('plant.index')}}" method="GET" class="grid grid-cols-4 gap-4">
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
                    <option value="" selected disabled>Jenis/Type</option>
                    @foreach ($jenis as $jns)
                        <option value="{{$jns->kode_unit}}" {{old('jenis', request()->jenis) == $jns->kode_unit ? 'selected' : ''}}>{{$jns->kode_unit}}</option>
                    @endforeach
                </select>
            </div>
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Select</button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap border table-fixed">
                    <thead class="bg-stone-800">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-1/3">No Unit</th>
                            <th colspan="4" class="px-4 py-3 text-center border-none">Jam Unit</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">WH</th>
                            <th class="px-4 py-3 border">BD</th>
                            <th class="px-4 py-3 border">STB</th>
                            <th class="px-4 py-3 border">MOHH</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @for($i=0; $i<count($data); $i++) 
                            <tr class="text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
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
            <div class="px-4 py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                {{$data->links()}}
            </div>
        </div>
</main>
@endsection