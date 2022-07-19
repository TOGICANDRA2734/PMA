@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Transaksi HM
        </h2>
        

        <form
            action="{{route('transaksi-plant.post')}}"
            method="POST"
            class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800"
        >
            @csrf
            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Nom Unit
                </span>
                <select
                    name="nom_unit"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($unit as $ut)
                        <option value="{{$ut->nom_unit}}">{{$ut->nom_unit}}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Site
                </span>
                <select
                    name="site"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($site as $st)
                        <option value="{{$st->kodesite}}">{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4 text-sm">
            <span class="font-semibold text-gray-700 dark:text-gray-400">HM</span>
            <input
                name="hm"
                class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Masukkan HM"
            />
            </label>

            <label class="block mt-4 text-sm">
            <span class="font-semibold text-gray-700 dark:text-gray-400">KM</span>
            <input
                name="km"
                class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                placeholder="Masukkan KM"
            />
            </label>

            <button type="submit" class="px-5 py-3 mt-4 font-medium leading-5 text-white transition-colors duration-150 bg-stone-700 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-900 focus:outline-none focus:shadow-outline-stone w-full">Submit</button>
        </form>
    </div>      
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>
@endsection