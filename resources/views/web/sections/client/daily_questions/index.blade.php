@extends('web.layout.navbar')

@section('content')
    <h3>web.client..daily_questions.index.blade.php</h3>
<ul>
    <li>de laatste 5 dag rapportages hier showen.</li>

</ul>    @foreach ($dailyQuestions as $dailyQuestion)
    <div class="row">
        <a href="{{ route('dailyQuestion.edit', ['user_id' => Auth::id(),'daily_question_id'=>$dailyQuestion->id]) }}" class="link-secondary"
            >{{ $dailyQuestion->created_at->diffForHumans() }}</a>

    </div>

    @endforeach



    </div>
@endsection
