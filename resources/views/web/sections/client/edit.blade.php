@extends('web.layout.navbar')

@section('content')
    <h3>web.client.edit.blade.php</h3>
    <h4>Wijzigen van persoonlijke gegevens</h4>
    <form action="{{ route('client.update',['client_id'=>Auth::user()->client->user_id]) }}" method="POST">
        {{ method_field('patch') }}

        @csrf
        <div class="row mt-3">
            <div class="col-sm-6">
                <input class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" value="{{ old('firstname', $client->firstname )}}"
                    placeholder="Voornaam">
                    @error('firstname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>

            <div class="col-sm-6">
                <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" value="{{ old('lastname', $client->lastname )}}"
                    placeholder="Achternaam">
                    @error('lastname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email', $client->user->email) }} " placeholder="email">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>

        </div>



        <div class="row mt-3">
            <div class="col-12">
                <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="{{old('phone_number',  $client->phone_number) }} " placeholder="Telefoon">
                @error('phone_number')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-sm-9">
                <input class="form-control @error('street') is-invalid @enderror" type="text" name="street" value="{{ old("street",$client->street) }} "
                    placeholder="Straatnaam">
                    @error('street')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-3">
                <input class="form-control @error('street_nr') is-invalid @enderror" type="text" name="street_nr" value="{{old("street_nr", $client->street_nr )}} "
                    placeholder="Straatnummer">
                    @error('street_nr')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-sm-9">
                <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value="{{ old("city",$client->city) }} "
                    placeholder="Plaats">
                    @error('city')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="col-sm-3">
                <input class="form-control @error('postcode') is-invalid @enderror" type="text" name="postcode" value="{{ old("postcode",$client->postcode) }} "
                    placeholder="Postcode">
                    @error('postcode')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


        </div>

        <button class="btn btn-primary mt-2" type="submit" name="action" value="update">Wijziging opslaan</button>


    </form>


@endsection
