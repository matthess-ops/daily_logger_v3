@extends('web.layout.navbar')

@section('content')
    <h3>web.client.daily_activities.edit.blade.php</h3>
    {{-- {{$activityValues}} --}}
    {{-- {{ json_encode($dailyActivityResults->colors) }}
    {{dump($dailyActivityResults)}} --}}
    {{-- {{ route('client.update-activities', ['id' => $activityLog->id]) }} --}}
    <form action="{{ route('dailyActivity.update', ['user_id' => Auth::id(), 'daily_activity_id' => $dailyActivityResults->id]) }}"
        method="POST">
        {{ method_field('patch') }}

        @csrf
        <button class="btn btn-primary m-1" type="submit" name="action" value="update">Opslaan</button>

        <div class="form-group row">
            <label>Main activity</label>
            <select class="form-control" name="main">
                @foreach ($activities as $activity)
                    @if ($activity->type == 'main')
                        <option value="{{ $activity->id }}">{{ $activity->value }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="row">
            <h3>Scaled values</h3>

        </div>
        @foreach ($activities as $activity)
            @if ($activity->type == 'scaled')
                <div class="row">

                    <div class="col-12">

                        <div class="form-group">
                            <label for="{{ $activity->id }}">{{ $activity->value }}</label>
                            <select class="form-control" id="{{ $activity->id }}" name="scaled[]">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="">3</option>
                                <option value="">4</option>
                                <option value="">5</option>
                                <option value="">6</option>
                                <option value="">7</option>
                                <option value="">8</option>
                                <option value="">9</option>
                                <option value="">10</option>

                                {{-- <option value="{{ json_encode(['id' => $activity->id, 'value' => 1]) }}">1</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 2]) }}">2</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 3]) }}">3</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 4]) }}">4</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 5]) }}">5</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 6]) }}">6</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 7]) }}">7</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 8]) }}">8</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 9]) }}">9</option>
                            <option value="{{ json_encode(['id' => $activity->id, 'value' => 10]) }}">10</option> --}}


                            </select>
                        </div>
                    </div>


                </div>
            @endif
        @endforeach

        <div class="row">
            <div class="col-1">
                index
            </div>
            <div class="col-2">
                time slot
            </div>
            <div class="col-2">
                main activity
            </div>
            <div class="col-6">
                @foreach ($dailyActivityResults->scaled_activities[0] as $scaledActivity)
                    {{ $scaledActivity }}
                @endforeach

            </div>

        </div>

        @php
            $moduloCounter = 1;
        @endphp

        @foreach ($dailyActivityResults->time_slots as $time_slot)
            @if ($loop->index % 4 == 0)
                <div class="row">
                    {{ $moduloCounter - 1 }}:00 - {{ $moduloCounter }}:00

                </div>


                @php
                    $moduloCounter = $moduloCounter + 1;
                @endphp
            @endif
            <div class="row">
                <div class="col-1">
                    {{ $loop->index }}

                </div>

                <div class="col-2">
                    <label class="customCheckbox">

                        <input type="checkbox" name="boxOn[]" value="{{$loop->index}}">
                        @if ($dailyActivityResults->colors[$loop->index] ==null)
                        <span style="background-color:chartreuse"
                            class="checkmark"></span>
                        @else
                        <span style="background-color:{{ $dailyActivityResults->colors[$loop->index] }}"
                            class="checkmark"></span>
                        @endif

                    </label>
                </div>

                <div class="col-2">
                    @if ($dailyActivityResults->main_activities[$loop->index] ==null)
                        Leeg
                    @else
                    {{ $dailyActivityResults->main_activities[$loop->index] }}

                    @endif

                </div>

                <div class="col-7">
                    @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                        {{ $scores }}
                    @endforeach
                </div>




            </div>
        @endforeach
    </form>






    <div>

        <h1>Custom Checkboxes</h1>
        <label class="customCheckbox">One
            <input style="background-color: #f0e74b;" type="checkbox" checked="checked">
            <span class="checkmark"></span>
        </label>
        <label class="customCheckbox">Two
            <input style="background-color: #f0e74b;" type="checkbox">
            <span class="checkmark"></span>
        </label>
        <label class="customCheckbox">Three
            <input type="checkbox">
            <span style="background-color:blueviolet" class="checkmark"></span>
        </label>
        <label class="customCheckbox">Four
            <input type="checkbox">
            <span class="checkmark"></span>
        </label>


    </div>
@endsection
