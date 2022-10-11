@extends('web.layout.navbar')

@section('content')


<h3>web.sections.graph.activities</h3>

<script src="{{ asset('js/graphactivities.js') }}" defer></script>
<button id="getdata" type="button" class="btn btn-primary">Get data</button>
<p id= "nrOfDays">empty</p>
{{$scaledActivities}}
<script>
    const dailyActivities = @json($dailyActivities);
    const mainActivitiesData = @json($mainActivities);
    const scaledActivitiesData = @json($scaledActivities);

</script>
<button type="button" name="" id="all" class="btn btn-primary" btn-lg btn-block">select all</button>

      <br>
<div id='interface'>



</div>




<h1>Chart JS Stacked Bar example</h1>
<div class="wrapper">
<canvas id="myChart4"></canvas>
</div>


@endsection
