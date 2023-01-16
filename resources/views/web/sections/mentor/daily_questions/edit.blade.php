@extends('web.layout.navbar')

@section('content')
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Dagelijkse rapportage</h5>
        </div>
    </div>
    {{-- {{ $dailyQuestions }} --}}
    <span>Client: {{ $dailyQuestions->client->firstname }} {{ $dailyQuestions->client->lastname }}</span> <br>

    <span>Datum: {{ $dailyQuestions->created_at->locale('nl')->translatedFormat('l d M Y') }}</span>


    <hr>

    <form action="{{ route('mentor.dailyquestion.update', ['question_id' => $dailyQuestions->id]) }}" method="POST">
        {{ method_field('patch') }}

        @csrf







        @php
            $dailyQuestionsValues = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            
        @endphp
        @foreach ($dailyQuestions->questions as $question)
            <div class="form-group">
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
            <textarea class="form-control @error('mentorRemark') is-invalid @enderror" name="mentorRemark" id="mentorRemark"
                rows="3">{{ old('mentorRemark', $dailyQuestions->mentor_remark) }}</textarea>
            @error('mentorRemark')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
        <div class="row mt-2">
            <div class="col-lg-3 col-sm-12">
                <button type="submit" class="btn btn-primary w-100">Opslaan</button>
            </div>
        </div>

    </form>

    {{-- <div class="row mt-2">
    <div class="col-lg-3 col-sm-12">
        <a name="" id="" class="btn btn-primary w-100" href="{{ route('mentor.dailyquestion.index') }}" role="button">Terug</a>
    </div>
</div> --}}
@endsection
