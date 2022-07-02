@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Distribusi Jam TP
        </h2>

        <!-- Filter -->
        <form action="{{route('distribusi-jam-tp.index')}}" method="GET" class="grid grid-cols-3 gap-4">
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
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Select</button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto" style="max-height: 36rem;">
                <table class="w-full whitespace-no-wrap border table-auto">
                    <thead class="bg-stone-800">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone">No Unit</th>
                            <th colspan="7" class="px-4 py-3 text-center border-r">Working Hours</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-r">BD</th>
                            <th colspan="19" class="px-4 py-3 text-center border-r">STB</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-r">MOHH</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-r">MA</th>
                            <th rowspan="2" class="px-4 py-3 text-center border-none">UTIL</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">OB</th>
                            <th class="px-4 py-3 border">ROOM</th>
                            <th class="px-4 py-3 border">PORT</th>
                            <th class="px-4 py-3 border">TRAV</th>
                            <th class="px-4 py-3 border">GEN</th>
                            <th class="px-4 py-3 border">RENT</th>
                            <th class="px-4 py-3 border">TOTAL</th>
                            @for($i=0; $i<=17; $i++)
                                <th class="px-4 py-3 border">S{{$i+1}}</th>
                            @endfor
                            <th class="px-4 py-3 border">TOTAL</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $values)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border">{{$key+1}}</td>
                                <td class="px-4 py-3 border">
                                    {{$values->nom_unit}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->OB, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->ROOM, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->POR, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->TRAV, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->GEN, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->RENT, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->TOTAL, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->BD, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S00, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S01, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S02, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S03, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S04, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S05, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S06, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S07, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S08, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S09, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S10, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S11, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S12, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S13, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S14, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S15, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S16, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->S17, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->STB, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->MOHH, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->MA, 1)}}
                                </td>
                                <td class="px-4 py-3 border">
                                    {{number_format($values->UT, 1)}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 text-xs tracking-wide text-white uppercase border bg-stone-800">
                {{$data->links()}}
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