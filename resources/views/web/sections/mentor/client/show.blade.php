@extends('web.layout.navbar')

@section('content')

    <h3>web.mentor.client.show.blade.php</h3>
    <h4>Persoonlijke gegevens</h4>
    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br><br>
    <h4>Grafieken</h4>

    <a name="" id="" class="btn btn-primary" href="{{route('graph.mentordailyreportsgraph',['user_id'=>$client->user_id])}}" role="button">Ga naar grafieken</a>






@endsection
