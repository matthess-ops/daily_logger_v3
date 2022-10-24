@extends('web.layout.navbar')

@section('content')

    <h3>web.admin.client.show.blade.php</h3>

    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br>
    <span>{{ $client->activity_time }} </span> <br><br>

    @if ($client->activity_time == '24hour')
    <form action="{{ route('clientWorkTime.update',['client_id'=>$client->id]) }}" method="POST">
       @csrf
       {{ method_field('patch') }}
       <input type="hidden" name="timeState" value="toWorkDay">

       <button type="submit" class="btn btn-primary">set naar werkdag</button>
    </form>


    @else
    <form action="{{ route('clientWorkTime.update',['client_id'=>$client->id]) }}" method="POST">
        @csrf

        {{ method_field('patch') }}
        <input type="hidden" name="timeState" value="to24Hour">

        <button type="submit" class="btn btn-primary">set naar 24 hour</button>
     </form>
    @endif

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
