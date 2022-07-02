@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Distribusi Jam PMA2B
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-5 gap-4">
            
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Select</button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap border">
                    <thead class="bg-stone-800">
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone w-20">No</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone">No Unit</th>
                            <th rowspan="2" class="px-4 py-3 border-b border-r border-stone">Kode</th>
                            <th colspan="20" class="px-4 py-3 text-center border-r">Working Hours</th>
                            <th colspan="19" class="px-4 py-3 text-center border-none">Status Standby</th>
                        </tr>
                        <tr class="text-xs font-semibold tracking-wide text-center text-white uppercase border-b dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3 border">rip</th>
                            <th class="px-4 py-3 border">doz</th>
                            <th class="px-4 py-3 border">ripdoz</th>
                            <th class="px-4 py-3 border">spr</th>
                            <th class="px-4 py-3 border">drill</th>
                            <th class="px-4 py-3 border">maint</th>
                            <th class="px-4 py-3 border">lr</th>
                            <th class="px-4 py-3 border">ll</th>
                            <th class="px-4 py-3 border">ls</th>
                            <th class="px-4 py-3 border">lb</th>
                            <th class="px-4 py-3 border">lm</th>
                            <th class="px-4 py-3 border">coal</th>
                            <th class="px-4 py-3 border">clean</th>
                            <th class="px-4 py-3 border">land</th>
                            <th class="px-4 py-3 border">gen</th>
                            <th class="px-4 py-3 border">trav</th>
                            <th class="px-4 py-3 border">rent</th>
                            <th class="px-4 py-3 border">totalwh</th>
                            <th class="px-4 py-3 border">bd</th>
                            <th class="px-4 py-3 border">mohh</th>
                            @for($i=0; $i<=17; $i++)
                                <th class="px-4 py-3 border">S{{$i+1}}</th>
                            @endfor
                            <th class="px-4 py-3 border">Total STB</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach($data as $key => $values)
                            <tr class="data-row text-center text-gray-700 dark:text-gray-400 hover:bg-gray-400 hover:text-white ease-in-out duration-150" onclick="changeColor(this)">
                                <td class="px-4 py-3 border">{{$key+1}}</td>
                                @foreach($values as $value)
                                    <td class="px-4 py-3 border">
                                        {{$value}}
                                    </td>
                                @endforeach
                            </tr>
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