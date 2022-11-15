@extends('web.layout.navbar')

@section('content')
    <script src="{{ asset('js/graphingv2.js') }}" defer></script>
    <script>
        const dailyQuestions = @json($dailyQuestions);
        const dailyActivities = @json($dailyActivities);
    </script>
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
                <input class="form-check-input" type="radio" name="activitiesQuestionsRadio" id="activitiesRadio"
                    value="activities" checked>
                <label class="form-check-label" for="activities">
                    Activiteiten:
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="activitiesQuestionsRadio" id="questionsRadio"
                    value="questions">
                <label class="form-check-label" for="questions">
                    Dagelijkse vragen:
                </label>
            </div>
        </div>

        <div id="datePicker">

        </div>
        <div id ="datePickerErrors">
        {{-- <div id="startEndWeekError" class="alert alert-danger">Eind week voor of gelijk aan start week</div> --}}

        </div>


        {{-- <div class="" id="weekpicker">
            <label for="startWeek">Start week:</label>
            <h3>Selecteer een start en eind week:</h3>

            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="startWeek" id="startWeek"
                value="">
            <label for="endWeek">Eind week:</label>
            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="endWeek" id="endWeek"
                >
            {{-- <div id="startEndWeekError" class="alert alert-danger d-none">Eind week voor of gelijk aan start week</div> --}}
            {{-- <div id="startEndWeekEmpty" class="alert alert-danger d-none">Eind en start week moeten een week bevatten</div>
        </div> --}}


        {{-- <div class="d-none" id="monthpicker">
            <label for="startMonth">Start maand:</label>
            <h3>Selecteer een start en eind maand:</h3>

            <input class="form-control mr-sm-2 " type="month" aria-label="Search" name="startMonth" id="startMonth"
                value="">
            <label for="endMonth">Eind maand:</label>
            <input class="form-control mr-sm-2 " type="month" aria-label="Search" name="endMonth" id="endMonth"
                value="">
            <div id="startEndMonthEmpty" class="alert alert-danger d-none">Eind en start maand moeten een week bevatten</div>
        </div> --}}


        <button id="makeGraphButton" type="button" class="btn btn-primary ">Maak Grafiek</button>

        <div id="checkBoxes">
        <div id="mainCheckBoxes">
            <h4>Main activities:</h4>
        </div>

        {{-- <button type="button" class="btn btn-primary"></button> --}}

        <div id ="scaledCheckBoxes">
            <h4>Scaled activities:</h4>

        </div>
    </div>
        <h1>Chart JS Stacked Bar example</h1>
        <div class="wrapper">
        <canvas id="testchart"></canvas>
        </div>


        <div class="wrapper" id="chartDiv">

        </div>






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
