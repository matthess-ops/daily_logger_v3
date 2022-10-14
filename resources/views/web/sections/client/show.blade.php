@extends('web.layout.navbar')

@section('content')
    <h3>web.client.show.blade.php</h3>

    <ul>
        <li>Met deactiveer stop je dat de client nog steeds dagelijkse rapportage en activiteiten logger entries worden aangemaakt</li>
        <li>De dagelijkse rapportage vragen veranderen op een apparte page zetten.</li>
    </ul>

    <br>
    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br><br>
    <span>Nieuw adres? Andere naam? Dat en meer pas je hier aan. </span><br>
    <a name="" id="" class="btn btn-primary" href="{{ route('client.edit', ['client_id' => Auth::user()->client->id]) }}"
        role="button">Account wijzigen</a>


    </div>
@endsection
