@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Transaksi Unit Baru
        </h2>

        <form
            action="{{route('transaksi-unit.store')}}"
            method="POST"
            enctype="multipart/form-data"
            class="px-4 py-3 mb-8 grid grid-cols-2 gap-5 bg-white rounded-lg shadow-md dark:bg-gray-800"
        >
            @csrf
            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Nomor Unit</span>
                <input
                    name='nom_unit'
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Nom Unit"
                />
            </label>
            

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Model Unit
                </span>
                <select
                    name="model"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($model as $data)
                        <option value="{{$data->model}}">{{$data->model}}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Type Unit
                </span>
                <select
                    name="type_unit"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                @foreach($type_unit as $tp)
                    <option value="{{$tp->type_unit}}">{{$tp->type_unit}}</option>
                @endforeach
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">SN</span>
                <input
                    name="sn"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Serial Number"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">
                    Engine Brand
                </span>
                <select
                    name="engine_brand"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:focus:shadow-outline-gray"
                >
                    @foreach($engine_brand as $data)
                        <option value="{{$data->engine_brand}}">{{$data->engine_brand}}</option>
                    @endforeach
                </select>
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Engine Model</span>
                <input
                    name="engine_model"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Engine Model"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Engine SN</span>
                <input
                    name="engine_sn"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Engine Serial Number"
                />
            </label>
            
            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">HP</span>
                <input
                    name="hp"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan HP"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Gambar 1</span>
                <input
                    name="pic_1"
                    type="file"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Gambar"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Gambar 2</span>
                <input
                    name="pic_2"
                    type="file"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Gambar"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Height</span>
                <input
                    name="height"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Height"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Width</span>
                <input
                    name="width"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Width"
                />
            </label>

            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Length</span>
                <input
                    name="length"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Length"
                />
            </label>
    
            <label class="block mt-4 text-sm">
                <span class="font-semibold text-gray-700 dark:text-gray-400">Fuel</span>
                <input
                    name="fuel"
                    class="block shadow-sm border p-2 rounded-md w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-stone-400 focus:outline-none focus:shadow-outline-stone dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    placeholder="Masukkan Fuel"
                />
            </label>

            <button type="submit" class="px-5 py-3 mt-4 col-span-2 font-medium leading-5 text-white transition-colors duration-150 bg-stone-700 border border-transparent rounded-lg active:bg-stone-600 hover:bg-stone-900 focus:outline-none focus:shadow-outline-stone w-full">Submit</button>
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
