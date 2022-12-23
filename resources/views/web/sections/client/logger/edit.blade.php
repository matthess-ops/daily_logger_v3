@extends('web.layout.navbar')

@section('content')
<h1>persoonlijke data encrypten met crypt library en triats</h1>
<ul>
    <li>
        https://www.positronx.io/laravel-traits-example/
    </li>
    <li>
        https://laracasts.com/discuss/channels/laravel/encrypting-model-data
    </li>
</ul>
    {{-- <ul>
    <li>waarde duplicaties uit de frontend halen om de layout rustiger te maken</li>
    <li>Wanneer een uurblok in is gevuld deze minimizen</li>
    <li>gehele uur selecteren knop anders makens cleaner</li>
    <li>dagelijkse rapportage vragen buttons van maken ipv een drop down</li>
</ul>
    <h3>web.client.logger.edit.blade.php</h3> --}}
    {{-- <h3>Activiteiten logger:</h3> --}}
    {{-- <ul>
        <li>Ymko vragen als hij de tijd per blokje wil of alleen aangeven als block vakn 10:00-11:00</li>
        <li>columns fixen voor smartphone en desktop</li>
    </ul> --}}
    {{-- <div class="row">

        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
        </div>
        <div class="form-check form-check-inline col-1">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
        </div>

    </div> --}}




    <script src="{{ asset('js/checkHourBoxes.js') }}" defer></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

    {{-- find correct cdn link later --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">



    @if ($dailyQuestions == null and $dailyActivityResults == null)
        <div>
            <h5>U hoeft vandaag geen data bij te houden. Indien u denkt dat dit niet klopt, neem dan contact op met uw
                begeleider.</h5>

        </div>
    @else
        <form action="{{ route('log.update', ['user_id' => Auth::id()]) }}" method="POST">
            {{ method_field('patch') }}

            @csrf
            <input name="dailyQuestionId" type="hidden" value="{{ $dailyQuestions->id }}">
            <input name="dailyActivityId" type="hidden" value="{{ $dailyActivityResults->id }}">



            <div class="row">
                <div class="col-12">
                    <h5>Activiteiten logger</h5>

                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <label for="main">Activiteiten</label>
                    <select class="form-control" name="main">
                        @foreach ($activities as $activity)
                            @if ($activity->type == 'main')
                                <option value="{{ $activity->id }}">{{ $activity->value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>


            @foreach ($activities as $activity)
                @if ($activity->type == 'scaled')
                    <div class="row">

                        <div class="col-12">

                            <div class="form-group">
                                <label for=" {{ $activity->id }}">Score tijdens activiteit voor:
                                    {{ $activity->value }}</label>
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
                    {{-- index --}}
                </div>
                <div class="col-2">
                    {{-- time slot --}}
                </div>
                <div class="col-2">
                    {{-- Activitieit --}}
                </div>
                <div class="col-6">
                    {{-- @foreach ($dailyActivityResults->scaled_activities[0] as $scaledActivity)
                        {{ $scaledActivity }}
                    @endforeach --}}

                </div>

            </div>

            @php
                $moduloCounter = 1;
            @endphp
            <div id="timeSlotDiv">
                @foreach ($dailyActivityResults->time_slots as $time_slot)
                    @if ($loop->index % 4 == 0)
                        <div class="row">
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-12">


                                <div class="collapse multi-collapse" id="scoreCollapse{{ $loop->index }}">
                                    <div style="width:100%" class="card card-body mb-2">
                                        @foreach ($dailyActivityResults->scaled_activities[0] as $scaledActivity)
                                            {{ $loop->index }}: {{ $scaledActivity }}
                                            <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1 col-2">
                                {{-- <button type="button" class="btn" name='hourButton' value='{{ $moduloCounter }}'><i
                                        class="fa-solid fa-plus"
                                        title='Selecteer alle checkboxes van: {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->format('H:i') }}-{{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->addHour()->format('H:i') }}'></i></button> --}}
                            </div>
                            <div class="col-sm-1 col-2">
                                <button type="button" class="btn" name='hourButton' value='{{ $moduloCounter }}'><i
                                        class="fa-solid fa-plus"
                                        title='Selecteer alle checkboxes van: {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->format('H:i') }}-{{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->addHour()->format('H:i') }}'></i></button>
                            </div>
                            <div class="col-sm-2 col-4">
                                Activiteit
                            </div>
                            <div class="col-4" title="{{ implode(',', $dailyActivityResults->scaled_activities[0]) }}">


                                Scores
                                <button type="button" class="btn p-0" data-toggle="collapse"
                                    href="#scoreCollapse{{ $loop->index }}" role="button" aria-expanded="false"
                                    aria-controls="scoreCollapse{{ $loop->index }}"><i
                                        style=""class="fa-solid fa-book"></i></button>

                            </div>
                            {{-- <div class="col-3">
                                {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->addHour()->format('H:i') }}
                                tijdblok:
                            </div> --}}

                            {{-- <div class="col-3">
                                <button type="button" class="btn btn-secondary btn-sm" name='hourButton'
                                    value='{{ $moduloCounter }}'> Selecteer alle {{ $moduloCounter - 1 }}:00 -
                                    {{ $moduloCounter }}:00 boxes
                                </button>

                            </div> --}}


                        </div>
                        {{-- <div class="row">

                            <div>
                                <button class="btn"><i class="fa-solid fa-plus"></i></button>

                            </div>
                        </div> --}}




                        @php
                            $moduloCounter = $moduloCounter + 1;
                        @endphp
                    @endif
                    <div class="row">
                        <div class="col-sm-1 col-2">
                            {{-- {{ $loop->index }} --}}
                            {{ \Carbon\Carbon::parse($dailyActivityResults->time_values[$loop->index])->format('H:i') }}


                        </div>

                        <div class="col-sm-1 col-2">
                            <label class="customCheckbox">

                                <input type="checkbox" name="boxOn[]" id="boxOn_{{ $loop->index }}"
                                    value="{{ $loop->index }}">
                                @if ($dailyActivityResults->colors[$loop->index] == null)
                                    <span style="background-color:chartreuse" class="checkmark  ml-1"></span>
                                @else
                                    <span style="background-color:{{ $dailyActivityResults->colors[$loop->index] }}"
                                        class="checkmark ml-1"></span>
                                @endif

                            </label>
                        </div>


                        <div class="col-sm-2 col-4">
                            @if ($loop->index > 0)
                                @if ($dailyActivityResults->main_activities[$loop->index] ==
                                    $dailyActivityResults->main_activities[$loop->index - 1])
                                    -
                                @else
                                    @if ($dailyActivityResults->main_activities[$loop->index] == null)
                                        Leeg
                                    @else
                                        {{ $dailyActivityResults->main_activities[$loop->index] }}
                                    @endif
                                @endif
                            @endif
                            @if ($loop->index == 0)
                                @if ($dailyActivityResults->main_activities[$loop->index] == null)
                                    Leeg
                                @else
                                    {{ $dailyActivityResults->main_activities[$loop->index] }}
                                @endif
                            @endif





                        </div>





                        <div class="col-4">

                            {{-- @if ($dailyActivityResults->main_activities[$loop->index] == null)
                                @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                                    Nan
                                @endforeach
                            @else
                                @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                                    @if ($scores == 0)
                                        n.v.t
                                    @else
                                        {{ $scores }}
                                    @endif
                                @endforeach
                            @endif --}}

                            @if ($loop->index > 0)
                                @if ($dailyActivityResults->scaled_activities_scores[$loop->index] ==
                                    $dailyActivityResults->scaled_activities_scores[$loop->index - 1])
                                    -
                                @else
                                    @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                                        @if ($scores == 0)
                                            n
                                        @else
                                            {{ $scores }}
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                            @if ($loop->index == 0)
                                @foreach ($dailyActivityResults->scaled_activities_scores[$loop->index] as $scores)
                                    @if ($scores == 0)
                                        n
                                    @else
                                        {{ $scores }}
                                    @endif
                                @endforeach
                            @endif




                        </div>




                    </div>
                @endforeach
            </div>
            <div class="row mt-2">
                <div class="col-lg-3 col-sm-12">
                    <button class="btn btn-primary m-1 mt-2 w-100" type="submit" name="action"
                        value="update">Opslaan</button>

                </div>

            </div>
            <hr />


            <div class="row">
                <div class="col-12">
                    <h5>Dag evaluatie</h5>

                </div>

            </div> @php
                $dailyQuestionsValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

            @endphp
            @foreach ($dailyQuestions->questions as $question)
                <div class="form-group">
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
                <textarea class="form-control @error('clientRemark') is-invalid @enderror"  name="clientRemark" id="clientRemark" rows="3">{{ old('clientRemark', $dailyQuestions->client_remark) }}</textarea>
                @error('clientRemark')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            {{-- <input class="form-control @error('city') is-invalid @enderror" type="text" name="city"
                value="{{ old('city', $client->city) }} " placeholder="Plaats"> --}}



            <div class="row mt-2">
                <div class="col-lg-3 col-sm-12">
                    <button class="btn btn-primary m-1 mt-2 w-100" type="submit" name="action"
                        value="update">Opslaan</button>

                </div>



            </div>
        </form>
    @endif




@endsection
