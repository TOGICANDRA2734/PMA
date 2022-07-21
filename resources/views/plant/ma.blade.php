@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            MA Unit
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-3 gap-4">
            <div class="">
                <label class="font-bold pb-1 text-sm" for="tahun">Tahun</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="tahun" id="tahun">
                @for($year=2022; $year>=2016; $year--)
                    <option value="{{$year}}" {{old('tahun', request()->tahun) == $year ? 'selected' : ''}}>{{$year}}</option>
                @endfor
                </select>
            </div>
            <div class="">
                <label class="font-bold pb-1 text-sm" for="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="site" id="site">
                    <option value="" selected>Semua Site</option>
                    @foreach ($site as $st)
                        <option value="{{$st->kodesite}}" {{old('site', request()->site) == $st->kodesite ? 'selected' : ''}}>{{$st->namasite}} - {{$st->lokasi}}</option>
                    @endforeach
                </select>
            </div>
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Proses</button>
        </form>

        <div class="w-full p-10 mt-10 bg-white">
            {{ $userChart->container() }}
        </div>
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>

<script src="https://unpkg.com/vue"></script>
<script>
    var app = new Vue({
        el: '#app',
    });
</script>
<script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
{!! $userChart->script() !!}
@endsection