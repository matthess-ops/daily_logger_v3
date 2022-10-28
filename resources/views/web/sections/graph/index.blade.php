@extends('web.layout.navbar')

@section('content')
    <script src="{{ asset('js/graphing.js') }}" defer></script>
    <script>
        const dailyQuestions = @json($dailyQuestions);
        const dailyActivities = @json($dailyActivities);
    </script>
    {{-- {{$dailyActivities}} --}}
    <ul>
        <li>hoe willen we de opmerkingen van de logger showen, onder terugkijken een tab bouwen?</li>
    </ul>

    <h3>web.sections.graph.index</h3>

    {{ json_encode(isset($dailyActivities)) }}
    {{ json_encode(!empty($dailyActivities)) }}

    @if (isset($dailyActivities) && !empty($dailyActivities))
        <div id="weekMonthRadio">
            <h3>Selecteer week of maand Grafiek output:</h3>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="weekMonthRadio" id="weekRadio" value="week" checked>
                <label class="form-check-label" for="weekRadio">
                    Week
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="weekMonthRadio" id="monthRadio" value="month">
                <label class="form-check-label" for="monthRadio">
                    Maand
                </label>
            </div>
        </div>


        <div id="weekMonthRadio">
            <h3>Selecteer Activiteiten logger of dagelijkse raportten grafieken:</h3>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="activitiesQuestionsRadio" id="activities"
                    value="activities" checked>
                <label class="form-check-label" for="activities">
                    Activiteiten:
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="activitiesQuestionsRadio" id="questions"
                    value="questions">
                <label class="form-check-label" for="questions">
                    Dagelijkse vragen:
                </label>
            </div>
        </div>
        <div class="" id="weekpicker">
            <label for="startWeek">Start week:</label>
            <h3>Selecteer een start en eind week:</h3>

            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="startWeek" id="startWeek"
                value="">
            <label for="endWeek">Eind week:</label>
            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="endWeek" id="endWeek"
                value="">
            <div id="startEndWeekError" class="alert alert-danger d-none">Eind week voor of gelijk aan start week</div>
            <div id="startEndWeekEmpty" class="alert alert-danger d-none">Eind en start week moeten een week bevatten</div>
        </div>


        <div class="d-none" id="monthpicker">
            <label for="startMonth">Start maand:</label>
            <h3>Selecteer een start en eind maand:</h3>

            <input class="form-control mr-sm-2 " type="month" aria-label="Search" name="startMonth" id="startMonth"
                value="">
            <label for="endMonth">Eind maand:</label>
            <input class="form-control mr-sm-2 " type="month" aria-label="Search" name="endMonth" id="endMonth"
                value="">
            <div id="startEndMonthError" class="alert alert-danger d-none">Eind maand voor of gelijk aan start maand</div>
            <div id="startEndMonthEmpty" class="alert alert-danger d-none">Eind en start maand moeten een week bevatten</div>
        </div>


        <button id="makeGraph" type="button" class="btn btn-primary ">Maak Grafiek</button>


        {{-- <h1>Chart JS Stacked Bar example</h1>
        <div class="wrapper">
        <canvas id="testchart"></canvas>
        </div> --}}






        {{--
        <input type="week" min="2022-W01" max="2022-W07">

        <input type="month" min="2022-01" max="2022-07"> --}}



        {{-- //////////////////////////// --}}
    @else
        <div class="alert alert-warning">
            <strong>Sorry!</strong> Geen logs gevonden.
        </div>
    @endif
@endsection
