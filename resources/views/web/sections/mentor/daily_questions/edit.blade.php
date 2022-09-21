@extends('web.layout.navbar')

@section('content')

    <h3>web.mentor.daily_questions.edit.blade.php</h3>
    {{ $dailyQuestions->client }}
    <h2>Vul de dagelijke raportage questions in voor de onderstaande client</h2>


    <span>{{ $dailyQuestions->client->firstname }} {{ $dailyQuestions->client->lastname }}</span> <br>
    

    <form action="{{ route('mentor.dailyquestion.update', ['question_id' => $dailyQuestions->id ])}}"
        method="POST">
        {{ method_field('patch') }}

        @csrf





    @foreach ($dailyQuestions->questions as $question)
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


    @endforeach
    <button type="submit" class="btn btn-primary">Opslaan</button>

</form>
 
@endsection
