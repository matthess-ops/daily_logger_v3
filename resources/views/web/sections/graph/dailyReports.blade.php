@extends('web.layout.navbar')

@section('content')


<h3>web.sections.graph.dailyreportsgraph</h3>

<script src="{{ asset('js/dailyquestionsgraph.js') }}" defer></script>
<ul>
    <li>vrije tekst input hier nog showen.</li>
</ul>
{{-- {{$dailyQuestions->map(function ($dailyQuestion) {
    return [$dailyQuestion->questions, $dailyQuestion->scores];
})}} --}}

<script>
    const dailyQuestions = @json($dailyQuestions);
</script>

<div id='interface'>

</div>


<h1>Chart JS Stacked Bar example</h1>
<div class="wrapper">
<canvas id="chart"></canvas>
</div>

@endsection
