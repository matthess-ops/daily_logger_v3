@extends('web.layout.navbar')

@section('content')
    <script src="{{ asset('js/indexDailyActivitiesGraph.js') }}" defer></script>
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
        <label for="startDate">Start datum:</label>
        <div id="datePickers">
            <h3>Selecteer start eind datum voor grafieken:</h3>

            <input class="form-control mr-sm-2 " type="date" aria-label="Search" name="startDate" id="startDate"
                value="">
            <label for="endDate">Eind datum:</label>
            <input class="form-control mr-sm-2 " type="date" aria-label="Search" name="endDate" id="endDate"
                value="">
            <div id="startEndDateError" class="alert alert-danger d-none">Eind datum is voor start datum.</div>
            <div id="startEndDateEmpty" class="alert alert-danger d-none">Eind en start datum moeten een datum bevatten.</div>


        </div>

        <div id="weekMonthRadio">
            <h3>Selecteer week of maand Grafiek output:</h3>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="weekMonthRadio" id="weekRadio" value="week">
                <label class="form-check-label" for="weekRadio">
                    Week
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="weekMonthRadio" id="monthRadio" value="month" checked>
                <label class="form-check-label" for="monthRadio">
                    Maand
                </label>
            </div>
        </div>


        <div id="weekMonthRadio">
            <h3>Selecteer Activiteiten logger of dagelijkse raportten grafieken:</h3>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="activitiesQuestionsRadio" id="activities" value="activities">
                <label class="form-check-label" for="activities">
                    Activiteiten:
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="activitiesQuestionsRadio" id="questions" value="questions" checked>
                <label class="form-check-label" for="questions">
                    Dagelijkse vragen:
                </label>
            </div>
        </div>

        <button id="makeGraph" type="button" class="btn btn-primary ">Maak Grafiek</button>














        {{-- //////////////////////////// --}}
    @else
        <div class="alert alert-warning">
            <strong>Sorry!</strong> Geen logs gevonden.
        </div>
    @endif

    {{-- <form method="GET" action="{{ route('graph.index', ['user_id' => Auth::id()]) }}" class="form-inline my-2 my-lg-0">
        @csrf
        <input class="form-control mr-sm-2 @error('startDate') is-invalid @enderror" type="date" aria-label="Search"
            name="startDate" value="@isset($backStartDate){{ $backStartDate }}@endisset">
        @error('startDate')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input class="form-control mr-sm-2 @error('endDate') is-invalid @enderror" type="date" aria-label="Search"
            name="endDate" value="@isset($backEndDate){{ $backEndDate }}@endisset">
        @error('endDate')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button class="btn btn-primary my-2 my-sm-0"  name="action" value="logger" type="submit">Logger</button>
        <button class="btn btn-primary my-2 my-sm-0" name="action" value="daily" type="submit">Dagelijkse vragen</button>
    </form>

    @isset($dailyActivities)
    Aantal dagen gevonden     {{ count($dailyActivities) }}
    <div>
          <input type="radio" id="week" name="timeMode" value="week">
          <label for="week">Week</label><br>
          <input type="radio" id="month" name="timeMode" value="month">
          <label for="month">Maand</label><br>
    </div>

    @endisset --}}
@endsection
