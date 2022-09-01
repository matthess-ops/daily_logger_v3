@extends('web.layout.navbar')

@section('content')

    <h3>web.admin.client.create.blade.php</h3>
    {{Auth::user()->role}}
    <form action="{{ route('client.store') }}" autocomplete="off" method="POST">

        @csrf
    <div class="row mt-3">
        <div class="col-12">
            <input class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" value="" placeholder="Voornaam">
            @error('firstname')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" value="" placeholder="Achternaam">
            @error('lastname')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            {{-- readonly onfocus="this.removeAttribute('readonly');" --}}
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


</form>





@endsection
