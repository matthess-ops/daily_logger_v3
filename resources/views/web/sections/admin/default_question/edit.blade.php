@extends('web.layout.navbar')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

@section('content')
        {{-- web.admin.default_question.index.blade.php</h3> --}}
        <div class="row mb-2">
            <div class="col">
                <h5 class="font-weight-bold">Standaard dagelijkse vragen configuratie</h5>
            </div>
        </div>
        <hr>

        @foreach ($defaultQuestions as $question)
        <div class="row mt-1">
            <div class="col-sm-3 col-10">
                {{ $question->question }}

            </div>
            <div class="col-sm-1 col-2">
                <form action="{{ route('defaultquestion.destroy', ['defaulquestion_id' => $question->id]) }}" method="POST">
                    @csrf
                    {{ method_field('delete') }}
                    <button type="submit" class="btn"> <i class="fa-solid fa-trash"></i>

                    </button>


                </form>

            </div>


        </div>
    @endforeach

    <hr>
    <form action="{{ route('defaultquestion.store')}}" method="POST">

        @csrf
        <div class="form-group">
            <label class="font-weight-bold" for="">Nieuwe standaard dagelijkse vraag</label>
            <input name="defaultQuestion" type="text" class="form-control @error('defaultQuestion') is-invalid @enderror"
                id="" aria-describedby="helpId" placeholder="">
            @error('defaultQuestion')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button type="submit" class="btn btn-primary w-100">Vraag toevoegen</button>
            </div>
        </div>

    </form>


@endsection
