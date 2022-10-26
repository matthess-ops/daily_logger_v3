@extends('web.layout.navbar')

@section('content')
    <h3>web.sections.graph.index</h3>
    old ddate = {{ old('startDate') }}


  {{-- @isset($thedate){{ $thedate }}@endisset --}}

    <form method="GET" action="{{ route('graph.index', ['user_id' => Auth::id()]) }}" class="form-inline my-2 my-lg-0">
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
    {{-- {{ $dailyActivities }} --}}
  
    @endisset

    




 
@endsection
