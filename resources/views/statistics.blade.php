@extends('layouts.app')


@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
<script>
@foreach ($names as $key=>$name)

    var {{$name}}Data = {
        labels:  [{!! json_encode($name) !!}],
        datasets: [{
            label: ['Twitch'],
            backgroundColor: "rgba(0,0,255,0.3)",
            data: ["{{isset($valuesT[$name])?$valuesT[$name]:0}}"]
         }, {
            label: ['Youtube'],
            backgroundColor: "rgba(0,176, 22, 22)",
            data: ["{{isset($valuesY[$name])?$valuesY[$name]:0}}"]
             }, {
            label: ['Vimeo'],
            backgroundColor: "rgba(0,22, 22, 176)",
            data: ["{{isset($valuesV[$name])?$valuesV[$name]:0}}"]

        }],

    };
    @endforeach


    window.onload = function() {
        @foreach ($names as $key=>$name)

        var {{$name}} = document.getElementById({!! json_encode($name) !!}).getContext("2d");
        window.myBar = new Chart({{$name}}, {
            type: 'bar',
            data: {{$name}}Data,
            options: {
                position: 'right',
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(192,192,192,0.3)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: false,
                legend: {
                     display: true,
                     position: 'right',
                },
                title: {
                    display: true,
                    text:'{{$name}} Statistics'
                },
            }
        });

    @endforeach

    };
</script>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
                     @foreach ($names as $key=>$name)

            <div class="panel panel-default">
                <div class="panel-heading"> {{$name}} Statistics</div>

                <div class="panel-body">
                    <canvas id="{{$name}}" height="400" width="700"></canvas>

                </div>

            </div>
                     @endforeach

        </div>

    </div>
</div>

@endsection
