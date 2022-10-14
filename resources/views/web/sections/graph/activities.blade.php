@extends('web.layout.navbar')

@section('content')


<h3>web.sections.graph.activities</h3>

<script src="{{ asset('js/graphactivities.js') }}" defer></script>

<script>
    const dailyActivities = @json($dailyActivities);
    const mainActivitiesData = @json($mainActivities);
    const scaledActivitiesData = @json($scaledActivities);

</script>

<ul>

    <li>week charts -> 7 dagen per chart of bar impact te voorkomen (mainactivities total per day en scaledactivitis average per day)</li>
    <li>nog bouwen een begin datum en een eind datum selecter</li>
    <li>maand chart -> 4 weken per chart (VRAAG: je voor mainactivity totals per week hebben of wil je deze gedeeld hebben door 5?)</li>
<li>maak ook filter buttons aan voor de scaled activities</li>
<li>voor definitieve versie alle main and scaled activities toggleble maken. </li>
<li>vrije tekst input helemaal vergeten zelfde geld voor de dagelijkse rapportage</li>
</ul>



<button type="button" name="" id="all" class="btn btn-primary" btn-lg btn-block">select all</button>

      <br>
<div id='interface'>



</div>




<h1>Chart JS Stacked Bar example</h1>
<div class="wrapper">
<canvas id="myChart4"></canvas>
</div>

<div>
    <ul>

    </ul>
</div>

<div class="wrapper">
    <canvas id="testchart"></canvas>
    </div>





@endsection
