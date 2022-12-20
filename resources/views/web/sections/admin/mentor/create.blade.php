@extends('web.layout.navbar')

@section('content')

<div class="row mb-2">
    <div class="col">
        <h5 class="font-weight-bold">Maak een begeleider aan</h5>
    </div>
</div>
    <form action="{{ route('mentor.store') }}" autocomplete="off" method="POST">

        @csrf

        <div class="row">
            <div class="col-12 mt-1">
                <input class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname"
                    value="{{ $errors->firstname== null ? '' : old('firstname') }}" placeholder="Voornaam">
                @error('firstname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <div class="col-12  mt-1">
                <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname"
                    value="{{ $errors->lastname== null ? '' : old('lastname') }}" placeholder="Achternaam">
                @error('lastname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <div class="col-12  mt-1">
                <input autocomplete="new" class="form-control @error('email') is-invalid @enderror" type="email"
                    name="email" value="{{ $errors->email== null ? '' : old('email') }}" placeholder="email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <div class="col-12  mt-1">
                <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number"
                    value="{{ $errors->phone_number== null ? '' : old('phone_number') }}" placeholder="Telefoon">
                @error('phone_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <div class="col-sm-9 mt-1">
                <input class="form-control @error('street') is-invalid @enderror" type="text" name="street"
                    value="{{ $errors->street== null ? '' : old('street') }}" placeholder="Straatnaam">
                @error('street')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-3  mt-1">
                <input class="form-control @error('street_nr') is-invalid @enderror" type="text" name="street_nr"
                    value="{{ $errors->street_nr== null ? '' : old('street_nr') }}" placeholder="Straatnummer">
                @error('street_nr')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <div class="col-sm-9 mt-1">
                <input class="form-control @error('city') is-invalid @enderror" type="text" name="city"
                value="{{ $errors->city== null ? '' : old('city') }}"
                    placeholder="Plaats">
                @error('city')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

            </div>
            <div class="col-sm-3  mt-1">
                <input class="form-control @error('postcode') is-invalid @enderror" type="text" name="postcode"
                    value="{{ $errors->postcode== null ? '' : old('postcode') }}" placeholder="Postcode">
                @error('postcode')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


        </div>

        <div class="row">
            <div class="col-12  mt-1">
                <input autocomplete="new" class="form-control @error('password') is-invalid @enderror" type="password"
                    name="password" value="" placeholder="Wachtwoord">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="row">
            <div class="col-lg-3 col-sm-12 mt-2">
                <button class="btn btn-primary w-100" type="submit" name="action" value="update">Opslaan</button>
            </div>
        </div>
    {{-- <div class="row mt-3">
        <div class="col-12">
            <input class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" value="{{ $errors->firstname== null ? '' : old('firstname') }}" placeholder="Voornaam">
            @error('firstname')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" value="{{ $errors->lastname== null ? '' : old('lastname') }}" placeholder="Achternaam">
            @error('lastname')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            <input autocomplete="new"  class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="" placeholder="email">
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            <input class="form-control @error('phone_number') is-invalid @enderror" type="text" name="phone_number" value="" placeholder="Telefoon">
            @error('phone_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-sm-9">
            <input class="form-control @error('street') is-invalid @enderror" type="text" name="street" value=""
                placeholder="Straatnaam">
                @error('street')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-sm-3">
            <input class="form-control @error('street_nr') is-invalid @enderror" type="text" name="street_nr" value=""
                placeholder="Straatnummer">
                @error('street_nr')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-sm-9">
            <input class="form-control @error('city') is-invalid @enderror" type="text" name="city" value=""
                placeholder="Plaat">
                @error('city')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
        <div class="col-sm-3">
            <input class="form-control @error('postcode') is-invalid @enderror" type="text" name="postcode" value=""
                placeholder="Postcode">
                @error('postcode')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


    </div>

    <div class="row mt-3">
        <div class="col-12">
            <input autocomplete="new" class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="" placeholder="Wachtwoord">
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <button class="btn btn-primary m-1" type="submit" name="action" value="update">Opslaan</button>
 --}}

</form>


@endsection
