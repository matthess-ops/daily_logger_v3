@extends('web.layout.navbar')

@section('content')


<h3>web.sections.graph.mentordailygraph</h3>
<script src="{{ asset('js/mentordailyquestionsgraph.js') }}" defer></script>

{{-- {{$dailyQuestions->map(function ($dailyQuestion) {
    return [$dailyQuestion->questions, $dailyQuestion->scores];
})}} --}}
<ul>
    <li>Alleen 1 report question doen die automatisch de client en mentor scores toggeld</li>
    <li>Hier toch alleen naar wekelijkse dag data kijken?</li>

</ul>

<script>
    const dailyQuestions = @json($dailyQuestions);
</script>
<div id='interface'>
<h4>show client answers</h4>

<div id='clientInterface'>

</div>
<h4>show mentor answers</h4>

<div id='mentorInterface'>

</div>
</div>

<h1>Chart JS Stacked Bar example</h1>
<div class="wrapper">
<canvas id="chart"></canvas>
</div>

@endsection
