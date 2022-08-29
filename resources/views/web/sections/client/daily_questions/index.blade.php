@extends('web.layout.navbar')

@section('content')
    <h3>web.client..daily_questions.index.blade.php</h3>
    {{-- {{ $dailyQuestions }} --}}
    @foreach ($dailyQuestions as $dailyQuestion)
    <div class="row">
        <a href="{{ route('dailyQuestion.edit', ['user_id' => Auth::id(),'daily_question_id'=>$dailyQuestion->id]) }}" class="link-secondary"
            >{{ $dailyQuestion->created_at->diffForHumans() }}</a>

    </div>
    
    @endforeach
   


    </div>
@endsection
