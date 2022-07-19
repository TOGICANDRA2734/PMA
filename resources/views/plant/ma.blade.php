@extends('layouts.admin.app', ['title' => 'Homepage | PT RCI | PMA 2023'])

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            MA Unit
        </h2>

        <form action="{{route(request()->route()->getName())}}" method="GET" class="grid grid-cols-3 gap-4">
            <div class="">
                <label class="font-bold pb-1 text-sm" for="type">Type Unit</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="type" id="type">
                    <option value="" selected>Semua Unit</option>

                   
                </select>
            </div>
            <div class="">
                <label class="font-bold pb-1 text-sm" for="site">Nama Site</label>
                <select class="p-2 border border-gray-100 rounded-md w-full" name="site" id="site">
                    <option value="" selected>Semua Site</option>

                   
                </select>
            </div>
            <button class="p-2 border bg-stone-800 border-gray-100 rounded-md text-white font-bold hover:bg-gray-900 duration-150 ease-in-out">Proses</button>
        </form>

        <!-- Content Table -->
        <div class="bg-white p-10 mt-5 rounded-lg">
            <canvas id="myChart"></canvas>
        </div>
</main>

<script>
    function changeColor(el){
        $('.data-row').removeClass('bg-gray-200', 'text-gray-700')
        $(el).addClass('bg-gray-200', 'text-white')
    }
</script>
<script>
  const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels, // <======= Here I set the x-axis
            datasets: [{
                label: '# of Votes',
                data: data, // <======= Here I set the y-axis
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection