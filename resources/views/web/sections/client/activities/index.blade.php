@extends('web.layout.navbar')

@section('content')
    {{-- <h3>web.client.activity.index.blade.php</h3>

    <h4>Wijzigen van activiteiten</h4> --}}
    {{-- <div class="container"> --}}
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Activiteiten aanpassen</h5>
        </div>
    </div>

    <form action="{{ route('clientActivities.destroy') }}"method="POST">
        @csrf
        @method('DELETE')
        <div class="row">
            <div class="col">
                <h6 class="">Score Activiteiten</h6>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">

                <label>Selecteer te verwijderen score activiteit:</label>
                <select class="form-control" name="removeActivity">
                    @foreach ($activities as $activity)
                        @if ($activity->type == 'scaled')
                            <option value="{{ $activity->id }}">{{ $activity->value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button class="btn btn-primary w-100" type="submit">Verwijder</button>

            </div>

        </div>

    </form>

    <form action="{{ route('clientActivities.store') }}" method="post">
        @csrf

        <div class="form-group row">
            <div class="col">
                <label for="">Toevoegen nieuwe score activiteit:</label>
                <input type="text" class="form-control" name="scaledActivity" id="" aria-describedby="helpId"
                    placeholder="">
                @error('scaledActivity')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button class="btn btn-primary w-100" type="submit">Toevoegen</button>

            </div>

        </div>


    </form>

    <hr>

    <form action="{{ route('clientActivities.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="row">
            <div class="col">
                <h6 class="">Activiteiten</h6>
            </div>
        </div>

        <div class="form-group row">
            <div class="col">
                <label>Selecteer te verwijderen activiteit:</label>
                <select class="form-control" name="removeActivity">
                    @foreach ($activities as $activity)
                        @if ($activity->type == 'main')
                            <option value="{{ $activity->id }}">{{ $activity->value }}</option>
                        @endif
                    @endforeach
                </select>
            </div>


        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button class="btn btn-primary w-100" type="submit">Verwijder</button>

            </div>

        </div>

    </form>

    <form action="{{ route('clientActivities.store') }}" method="post">
        @csrf

        <div class="form-group row">
            <div class="col">
                <label for="">Toevoegen nieuwe activiteit:</label>
                <input type="text" class="form-control" name="mainActivity" id="" aria-describedby="helpId"
                    placeholder="">
                @error('mainActivity')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>


        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                <button class="btn btn-primary w-100" type="submit">Toevoegen</button>
            </div>
        </div>
    </form>
@endsection
