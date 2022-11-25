@extends('web.layout.navbar')

@section('content')

    <h3>web.mentor.daily_questions.edit.blade.php</h3>
    {{-- <p>Client: {{ $dailyQuestions->client }}</p> --}}
    <h2>Vul de dagelijke waardering vragen van de client in</h2>


    <span>Client: {{ $dailyQuestions->client->firstname }} {{ $dailyQuestions->client->lastname }}</span> <br>
    {{$dailyQuestions}}

    <form action="{{ route('mentor.dailyquestion.update', ['question_id' => $dailyQuestions->id ])}}"
        method="POST">
        {{ method_field('patch') }}

        @csrf





    {{-- @foreach ($dailyQuestions->questions as $question)
    <div class="form-group">
        {{ $loop->index }}
      <label for="">{{ $question  }}</label>
      <select class="form-control" name="scores[]" id="">

        @for ($i = 1; $i < 10; $i++)
        @if($dailyQuestions->mentor_scores[$loop->index] == $i)
        <option selected value="{{ $i }}">{{ $i }}</option>

        @else
        <option value="{{ $i }}">{{ $i }}</option>

        @endif
        @endfor



      </select>
    </div>


    @endforeach --}}


    @php
                $dailyQuestionsValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

            @endphp
            {{ json_encode($dailyQuestions->mentor_scores) }}
            @foreach ($dailyQuestions->questions as $question)
                <div class="form-group">
                    {{ $loop->index }}
                    <label for="">{{ $question }}</label>

                    <select class="form-control" name="mentorScores[]" id="">
                        @if ($dailyQuestions->mentor_scores[$loop->index] === null)
                            <option selected value="{{ null }}">Leeg</option>
                        @endif
                        @if ($dailyQuestions->mentor_scores[$loop->index] === 0)
                            <option selected value="{{ 0 }}">n.v.t</option>
                        @else
                            <option value="{{ 0 }}">n.v.t</option>
                        @endif
                        @for ($i = 1; $i <= 10; $i++)
                            @if ($dailyQuestions->mentor_scores[$loop->index] === $i)
                                <option selected value="{{ $i }}">{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor

                    </select>

                </div>
            @endforeach


    <div class="form-group">
        <label for="clientRemark">Opmerking:</label>
        <textarea class="form-control" name="mentorRemark" id="mentorRemark" rows="3">{{ $dailyQuestions->mentor_remark }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Opslaan</button>

</form>

<a name="" id="" class="btn btn-primary" href="{{ route('mentor.dailyquestion.index') }}" role="button">Terug</a>
{{-- {{ url()->previous() }} ​ --}}

@endsection
