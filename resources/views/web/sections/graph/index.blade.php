@extends('web.layout.navbar')

@section('content')

{{-- <ul>
    <li>wat je eigenlijk wil hebben is dat je een paar activiteiten kan selecteren
        en dan kan zien wat de scores aan deze activiteiten waren. Op deze manier
        kan je dan achterhalen wat ontspannende activiteiten zijn.
    </li>
    <li>Of een score activiteit selecteren en dan een break down kan zien van alle activiteiten en
        hoe de persoon zich voelde tijdens deze activiteiten. Op deze manier is 1 in keer zichtbaar
        bij welke activiteit de patient zicht het meest gespannen/ontspannen zicht voelt.
    </li>
</ul> --}}
    <script src="{{ asset('js/graphfrontend.js') }}" defer></script>
    <script>
        const dailyQuestions = @json($dailyQuestions);
        const dailyActivities = @json($dailyActivities);
    </script>


    <div class="row mb-1">
        <div class="col-12">
            <h5>Overzicht</h5>

        </div>

    </div>



    @if (isset($dailyActivities) && !empty($dailyActivities))
        <div id="weekMonthRadio">
            <h5>Selecteer dagelijkse of wekelijkse grafieken</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dayWeekRadio" id="dayRadio" value="day" checked>
                <label class="form-check-label" for="dayRadio">
                    Dagelijks
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="dayWeekRadio" id="weekRadio" value="week">
                <label class="form-check-label" for="weekRadio">
                    Wekelijks
                </label>
            </div>
        </div>


        <div id="weekMonthRadio" class="mt-2">
            <h5>Selecteer activiteiten of dag rapportage visualisatie:</h5>
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

        <div id="datePicker" class="mt-2">
            <h5>Selecteer start en eind week</h5>

            <label for="startWeek">Start week:</label>

            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="startWeek" id="startWeek"
                value="">
            <label for="endWeek">Eind week:</label>
            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="endWeek" id="endWeek">
        </div>
        <div id="datePickerErrors" class="mt-2">

        </div>


        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button id="makeGraphButton" type="button" class="btn btn-primary w-100">Maak Grafiek</button>

            </div>

        </div>

        <hr>


        <div id="checkBoxes">

        </div>



        <div class="wrapper" id="chartDiv">

        </div>
    @else
        <div class="alert alert-warning">
            <strong>Sorry!</strong> Geen logs gevonden.
        </div>
    @endif
@endsection
