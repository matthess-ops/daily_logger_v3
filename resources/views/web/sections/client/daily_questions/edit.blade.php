@extends('web.layout.navbar')

@section('content')
    <h3>web.client.daily_questions.edit.blade.php</h3>
    {{ $dailyQuestions }}
    <form action="{{ route('dailyQuestion.update', ['user_id' => Auth::id(), 'daily_question_id' => $dailyQuestions->id]) }}"
        method="POST">
        {{ method_field('patch') }}

        @csrf





        @foreach ($dailyQuestions->questions as $question)
            <div class="form-group">
                {{ $loop->index }}
                <label for="">{{ $question }}</label>
                <select class="form-control" name="scores[]" id="">

                    @for ($i = 1; $i < 10; $i++)
                        @if ($dailyQuestions->scores[$loop->index] == $i)
                            <option selected value="{{ $i }}">{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor

                </select>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Opslaan</button>

    </form>
@endsection
