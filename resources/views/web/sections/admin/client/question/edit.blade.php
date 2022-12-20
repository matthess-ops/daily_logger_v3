@extends('web.layout.navbar')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

@section('content')
    {{-- <h3>web.admin.client.question.edit.blade.php</h3> --}}
    {{-- {{ $questions->first() }} --}}
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Dagelijkse vragen client config</h5>
        </div>
    </div>
    <hr>




    @foreach ($questions as $question)
        <div class="row mt-1">
            <div class="col-sm-3 col-10">
                {{ $question->question }}

            </div>
            <div class="col-sm-1 col-2">
                <form action="{{ route('question.destroy', ['question_id' => $question->id]) }}" method="POST">
                    @csrf
                    {{ method_field('delete') }}
                    <button type="submit" class="btn"> <i class="fa-solid fa-trash"></i>

                    </button>


                </form>

            </div>


        </div>
    @endforeach
    <hr>
    <div class="row">
        <div class="col">
            <h6 class="font-weight-bold">Reset de vragen naar de standaard vragen</h6>
        </div>
    </div>
    <form action="{{ route('question.update', ['user_id' => $client->user_id]) }}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button type="submit" class="btn btn-primary w-100">Reset vragen</button>
            </div>
        </div>
    </form>
    <hr>

    {{-- <h3>Add new question</h3> --}}
    <form action="{{ route('question.store', ['user_id' => $client->user_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="font-weight-bold" for="">Nieuwe dagelijkse vraag</label>
            <input name="question" type="text" class="form-control @error('question') is-invalid @enderror"
                id="" aria-describedby="helpId" placeholder="">
            @error('question')
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
