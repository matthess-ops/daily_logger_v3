@extends('web.layout.navbar')

@section('content')
    <h3>web.admin.client.question.edit.blade.php</h3>
    {{-- {{ $questions->first() }} --}}
    @foreach ($questions as $question)
        <div class="row">
            <div class="col-1">
                {{ $loop->index }}
            </div>
            <div class="col-4">
                {{ $question->question }}
            </div>
            <div class="col-3">
                <form action="{{ route('question.destroy', ['question_id' => $question->id]) }}" method="POST">
                    @csrf
                    {{ method_field('delete') }}
                    <button type="submit" class="btn btn-primary">Verwijder vraag</button>
                </form>
            </div>
        </div>
    @endforeach
        {{-- {{$questions->first()->client}} --}}
    <h3>Add new question</h3>
    <form action="{{ route('question.store', ['user_id' => $client->user_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="">New Question</label>
            <input name="question" type="text" class="form-control @error('postcode') is-invalid @enderror"
                id="" aria-describedby="helpId" placeholder="">
            @error('question')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Vraag toevoegen</button>
    </form>


    <form action="{{ route('question.update', ['user_id' => $client->user_id]) }}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <button type="submit" class="btn btn-primary">Set to default questions</button>
    </form>




@endsection
