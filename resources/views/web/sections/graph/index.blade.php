@extends('web.layout.navbar')

@section('content')
    <script src="{{ asset('js/graphfrontend.js') }}" defer></script>
    <script>
        const dailyQuestions = @json($dailyQuestions);
        const dailyActivities = @json($dailyActivities);
    </script>
    <ul>
        <li>de Remarks collasable makeken dus een button toevoegen om de remarks van eze week/8 weken te showen?</li>
    </ul>

    <h3>web.sections.graph.index</h3>

    {{ json_encode(isset($dailyActivities)) }}
    {{ json_encode(!empty($dailyActivities)) }}

    @if (isset($dailyActivities) && !empty($dailyActivities))
        <div id="weekMonthRadio">
            <h3>Dagelijkse of wekelijkse output:</h3>
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


        <div id="weekMonthRadio">
            <h3>Selecteer Activiteiten logger of dagelijkse raporten grafieken:</h3>
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
            <h3>Selecteer een start en eind week:</h3>

            <label for="startWeek">Start week:</label>

            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="startWeek" id="startWeek"
                value="">
            <label for="endWeek">Eind week:</label>
            <input class="form-control mr-sm-2 " type="week" aria-label="Search" name="endWeek" id="endWeek">
        </div>
        <div id="datePickerErrors">
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
            {{-- <div id="mainCheckBoxes">
            </div> --}}

            {{-- <button type="button" class="btn btn-primary"></button> --}}

            {{-- <div id="scaledCheckBoxes">

            </div> --}}
        </div>
        {{-- <h1>Chart JS Stacked Bar example</h1>
        <div class="wrapper">
        <canvas id="testchart"></canvas>
        </div> --}}


        <div class="wrapper" id="chartDiv">

        </div>

        {{-- <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                            Clienten opmerkingen:
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        had een slechte dag vandaag
                    </div>
                </div>
            </div>

            <div id='accordion'>
                <div class='card'>
                    <div class='card-header' id='headingOne'>
                        <h5 class='mb-0'>
                            <button class='btn btn-link' data-toggle='collapse' data-target='#collapseOne' aria-expanded='true'
                                aria-controls='collapseOne'>
                                Clienten opmerkingen:
                            </button>
                        </h5>
                    </div>
            
                    <div id='collapseOne' class='collapse' aria-labelledby='headingOne' data-parent='#accordion'>
                        <div class='card-body'>
                            had een slechte dag vandaag
                        </div>
                    </div>
                </div> --}}

      
        @else
            <div class="alert alert-warning">
                <strong>Sorry!</strong> Geen logs gevonden.
            </div>
    @endif
@endsection
