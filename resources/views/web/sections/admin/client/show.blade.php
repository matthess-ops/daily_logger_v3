@extends('web.layout.navbar')

@section('content')

    <h3>web.admin.client.show.blade.php</h3>

    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br><br>

    @if ($client->user->active)
    <form action="{{route('client.update',['client_id'=>$client->id])}}" method="POST">
       @csrf
       {{ method_field('patch') }}
       <button type="submit" class="btn btn-primary">Deactiveer account</button>
    </form>


    @else
    <form action="{{route('client.update',['client_id'=>$client->id])}}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <button type="submit" class="btn btn-primary">Activeer account</button>
     </form>
    @endif

    <h2>Client Daily Questions</h2>
    @foreach ($client->questions as $question)
    <div class="row">
        <div class="col-1">
            {{$loop->index}}
        </div>
        <div class="col-11">
            {{$question->question}}
        </div>
    </div>


    @endforeach
    <a name="" id="" class="btn btn-primary" href="{{route('question.edit',['client_id'=>$client->id])}}" role="button">Edit questions</a>







@endsection
