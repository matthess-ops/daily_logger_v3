@extends('web.layout.navbar')

@section('content')
    <h3>
        web.admin.default_question.index.blade.php</h3>
        {{$defaultQuestions}}

        @foreach ($defaultQuestions as $question)
        <div class="row">
            <div class="col-1">
                {{ $loop->index }}
            </div>
            <div class="col-4">
                {{ $question->question }}
            </div>
            <div class="col-3">
                <form action="{{ route('defaultquestion.destroy', ['defaulquestion_id' => $question->id]) }}" method="POST">
                    @csrf
                    {{ method_field('delete') }}
                    <button type="submit" class="btn btn-primary">Verwijder vraag</button>
                </form>
            </div>
        </div>
    @endforeach

    <h3>Add new default question</h3>
    {{$errors}}
    <form action="{{ route('defaultquestion.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="">New Default Question</label>
            <input name="defaultQuestion" type="text" class="form-control @error('defaultQuestion') is-invalid @enderror"
                id="" aria-describedby="helpId" placeholder="">
            @error('defaultQuestion')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Vraag toevoegen</button>
    </form>


@endsection
