@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Produksi A2B
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-3 gap-4">
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
            <div class="w-full overflow-x-auto"  style="max-height: 36rem;">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800 sticky top-0">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone">No Unit</th>
                            <th colspan="5" class="px-4 py-3 text-center border-r">Jam Unit</th>
                            <th colspan="4" class="px-4 py-3 text-center border-none">Produksi</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">WH Total</th>
                            <th class="px-4 py-3 border">WHOB Total</th>
                            <th class="px-4 py-3 border">BD Total</th>
                            <th class="px-4 py-3 border">STB Total</th>
                            <th class="px-4 py-3 border">MOHH Total</th>
                            <th class="px-4 py-3 border">OB (BCM)</th>
                            <th class="px-4 py-3 border">RIT</th>
                            <th class="px-4 py-3 border">PTY</th>
                            <th class="px-4 py-3 border">Jarak</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $values)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border">{{$key+1}}</td>
                                @foreach($values as $keys => $value)
                                    @if($keys != "distbcm")
                                        @if(is_double($value))
                                            <td class="px-4 py-3 border">
                                                {{number_format($value, 1, ",", ".")}}
                                            </td>
                                        @else
                                            <td class="px-4 py-3 border">
                                                {{$value}}
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            @if(isset(($data[$key + 1])))
                                @php 
                                    $nextRow = $data[$key + 1]
                                @endphp

                                @if(substr($values->nom_unit,0,2) != substr($nextRow->nom_unit,0,2))
                                    <tr class="data-row text-center text-gray-700 bg-gray-300 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                        <td class="px-4 py-3 text-sm" colspan="2">Total Unit</td>
                                        @php
                                            $hasilFilter = $filter->filter(function($item, $key) use ($values){
                                                return in_array($key, [substr($values->nom_unit,0,2)]);
                                            });
                                        @endphp
                                        @foreach($hasilFilter as $ft)
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->wh, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->WHOB, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->BD, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->STB, 1, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->MOHH, 0, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->bcm,1, ",", ".")}}
                                            </td>     
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->rit,0, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->pty,0, ",", ".")}}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                {{number_format($ft->jarak,0, ",", ".")}}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @elseif($key == count($data)-1)
                                <tr class="data-row text-center text-gray-700 bg-gray-300 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150">
                                    <td class="px-4 py-3 text-sm" colspan="2">Total Unit</td>
                                    @php
                                        $hasilFilter = $filter->filter(function($item, $key) use ($values){
                                            return in_array($key, [substr($values->nom_unit,0,2)]);
                                        });
                                    @endphp
                                    @foreach($hasilFilter as $ft)
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->wh, 1, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->WHOB, 1, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->BD, 1, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->STB, 1, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->MOHH, 0, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->bcm,1, ",", ".")}}
                                        </td>     
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->rit,0, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->pty,0, ",", ".")}}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            {{number_format($ft->jarak,0, ",", ".")}}
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
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