@extends('web.layout.navbar')

@section('content')
<ul>
    <li>waarde duplicaties uit de frontend halen om de layout rustiger te maken</li>
    <li>Wanneer een uurblok in is gevuld deze minimizen</li>
    <li>gehele uur selecteren knop anders makens cleaner</li>
    <li>dagelijkse rapportage vragen buttons van maken ipv een drop down</li>
</ul>
    <h3>web.client.logger.edit.blade.php</h3>
    <h3>Rapportage vandaag:</h3>

 

    <script src="{{ asset('js/checkHourBoxes.js') }}" defer></script>
 
    @if ($dailyQuestions == null or $dailyActivityResults == null)
        <h2>Looks like that there arent any entries</h2>
    @else
        <form action="{{ route('log.update', ['user_id' => Auth::id()]) }}" method="POST">
            {{ method_field('patch') }}

            @csrf
            <input name="dailyQuestionId" type="hidden" value="{{ $dailyQuestions->id }}">
            <input name="dailyActivityId" type="hidden" value="{{ $dailyActivityResults->id }}">


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
                                    <option value="0">n.v.t</option>

                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>




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
            <div id="timeSlotDiv">
                @foreach ($dailyActivityResults->time_slots as $time_slot)
                    @if ($loop->index % 4 == 0)
                        <div class="row">
                            {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->addHour()->format('H:i') }}

                            {{-- {{ $moduloCounter - 1 }}:00 - {{ $moduloCounter }}:00 --}}
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-sm" name='hourButton'
                                value='{{ $moduloCounter }}'> Selecteer alle {{ $moduloCounter - 1 }}:00 -
                                {{ $moduloCounter }}:00 boxes
                            </button>
                            {{-- <div class="form-check">
                          <label class="form-check-label">

                            <input type="checkbox" class="form-check-input" name="hourBoxesOn" id="hourBoxesOn" value="{{$moduloCounter}}" >
                            Selecteer alle {{ $moduloCounter - 1 }}:00 - {{ $moduloCounter }}:00 boxes
                          </label>
                        </div> --}}
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

                                <input type="checkbox" name="boxOn[]" id="boxOn_{{ $loop->index }}"
                                    value="{{ $loop->index }}">
                                @if ($dailyActivityResults->colors[$loop->index] == null)
                                    <span style="background-color:chartreuse" class="checkmark"></span>
                                @else
                                    <span style="background-color:{{ $dailyActivityResults->colors[$loop->index] }}"
                                        class="checkmark"></span>
                                @endif

                            </label>
                        </div>

                        <div class="col-2">
                            @if ($dailyActivityResults->main_activities[$loop->index] == null)
                                Leeg
                            @else
                                {{ $dailyActivityResults->main_activities[$loop->index] }}
                            @endif

                        </div>

                        <div class="col-7">
                            @if ($dailyActivityResults->main_activities[$loop->index] == null)
                                @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                                    Nan
                                @endforeach
                            @else
                                @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                                    {{-- {{ $scores }} --}}
                                    @if ($scores == 0)
                                        n.v.t
                                    @else
                                        {{ $scores }}
                                    @endif
                                @endforeach
                            @endif




                        </div>




                    </div>
                @endforeach
            </div>
            <h3>Waardering</h3>
            @php
                $dailyQuestionsValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

            @endphp
            {{ json_encode($dailyQuestions->scores) }}
            @foreach ($dailyQuestions->questions as $question)
                <div class="form-group">
                    {{ $loop->index }}
                    <label for="">{{ $question }}</label>

                    <select class="form-control" name="scores[]" id="">
                        @if ($dailyQuestions->scores[$loop->index] === null)
                            <option selected value="{{ null }}">Leeg</option>
                        @endif
                        @if ($dailyQuestions->scores[$loop->index] === 0)
                            <option selected value="{{ 0 }}">n.v.t</option>
                        @else
                            <option value="{{ 0 }}">n.v.t</option>
                        @endif
                        @for ($i = 1; $i <= 10; $i++)
                            @if ($dailyQuestions->scores[$loop->index] === $i)
                                <option selected value="{{ $i }}">{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor

                    </select>

                </div>
            @endforeach
            <div class="form-group">
                <label for="clientRemark">Opmerking</label>
                <textarea class="form-control" name="clientRemark" id="clientRemark" rows="3">{{ $dailyQuestions->client_remark }}</textarea>
            </div>


            <button type="submit" class="btn btn-primary">Opslaan</button>

        </form>
    @endif




@endsection


<script>
    function myFunction() {
console.log("werkt")    }
    </script>