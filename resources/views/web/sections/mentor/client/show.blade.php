@extends('web.layout.navbar')

@section('content')
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Persoonlijke gegevens</h5>
        </div>
    </div>



    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br><br>
    <br>

    <div class="row">
        <div class="col">
            <h6 class="">Client activiteiten visualisatie</h6>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-sm-12">
            {{-- <button class="btn btn-primary w-100" type="submit">Verwijder</button> --}}
            <a name="" id="" class="btn btn-primary w-100"
            href="{{ route('graph.mentordailyreportsgraph', ['user_id' => $client->user_id]) }}" role="button">Ga naar grafieken</a>
        </div>

    </div>



@endsection
