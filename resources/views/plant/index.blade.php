@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Populasi Unit
        </h2>

        <div class="grid grid-cols-4 gap-4">
            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Bulan</option>
                @for ($x=1; $x<=12; $x++)
                    <option value="{{$x}}">{{ date('F', mktime(0,0,0, $x, 1)) }}</option>
                @endfor
            </select>
            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Tahun</option>
                @for ($y=0; $y<count($tahun); $y++)
                    <option value="">{{$tahun[$y]}}</option>
                @endfor
            </select>

            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Site</option>
                @foreach ($site as $st)
                    <option value="{{$st->kodesite}}">{{$st->namasite}}</option>
                @endforeach
            </select>
            <select class="p-2 border border-gray-100 rounded-md" name="" id="">
                <option value="" selected disabled>Jenis/Type</option>
                <option value="">{{$jenis}}</option>
            </select>
        </div>

        <!-- Content Table -->
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-4 inline-block min-w-full sm:px-3 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-600">
                                <tr>
                                    <th rowspan="2" scope="col" class="text-sm font-medium text-white px-3 py-4">
                                        No
                                    </th>
                                    <th rowspan="2" scope="col" class="text-sm font-medium text-white px-3 py-4">
                                        No Unit
                                    </th>
                                    <th colspan="4" scope="col" class="text-sm font-medium text-white px-3 py-4">
                                        Jam Unit
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col" class="text-sm font-medium text-white px-3 py-1">WH</th>
                                    <th scope="col" class="text-sm font-medium text-white px-3 py-1">BD</th>
                                    <th scope="col" class="text-sm font-medium text-white px-3 py-1">STB</th>
                                    <th scope="col" class="text-sm font-medium text-white px-3 py-1">MOHH</th>
                                </tr>
                            </thead class="border-b">
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1</td>
                                    <td class="text-sm text-gray-900 font-light px-3 py-4 whitespace-nowrap">
                                        Mark
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-3 py-4 whitespace-nowrap">
                                        Otto
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-3 py-4 whitespace-nowrap">
                                        Otto
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-3 py-4 whitespace-nowrap">
                                        Otto
                                    </td>
                                    <td class="text-sm text-gray-900 font-light px-3 py-4 whitespace-nowrap">
                                        Otto
                                    </td>
                                </tr class="bg-white border-b">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection