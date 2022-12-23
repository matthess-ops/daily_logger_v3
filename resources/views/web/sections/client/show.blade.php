@extends('web.layout.navbar')

@section('content')
    {{-- <h3>web.client.show.blade.php</h3> --}}


    <div class="container">

    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Persoonlijke gegevens</h5>
        </div>
    </div>

 {{-- clientdata{{json_encode($client)}} --}}

    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br><br>
    <span>Nieuw adres? Andere naam? Dat en meer pas je hier aan. </span><br>



    </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12 mt-2">
                <a name="" id="" class="btn btn-primary w-100" href="{{ route('client.edit', ['client_id' => Auth::user()->client->id]) }}"
                    role="button">Account wijzigen</a>        </div>
        </div>
    </div>

@endsection
