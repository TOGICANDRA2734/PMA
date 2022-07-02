@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Populasi Unit PMA2B
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-5 gap-4">
            
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Select</button>
        </form>

        <!-- Content Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs mt-5 mb-5">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap border table-fixed">
                    <thead class="bg-stone-800">
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
                            <th class="px-4 py-3 border">RIT</th>
                            <th class="px-4 py-3 border">OB (BCM)</th>
                            <th class="px-4 py-3 border">DIST</th>
                            <th class="px-4 py-3 border">PTY</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
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