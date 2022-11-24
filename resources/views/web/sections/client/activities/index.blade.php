@extends('web.layout.navbar')

@section('content')
    <h3>web.client.activity.index.blade.php</h3>

    <h4>Wijzigen van activiteiten</h4>


    <form action="{{ route('clientActivities.destroy') }}"method="POST">
        @csrf
        @method('DELETE')
        <div class="form-group row">
            <label>Selecteer te verwijderen waardering:</label>
            <select class="form-control" name="removeActivity">
                @foreach ($activities as $activity)
                    @if ($activity->type == 'scaled')
                        <option value="{{ $activity->id }}">{{ $activity->value }}</option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-primary mt-2" type="submit">Verwijder</button>

        </div>

    </form>

    <form action="{{ route('clientActivities.store') }}" method="post">
        @csrf

        <div class="form-group row">
            <label for="">Toevoegen nieuwe waardering:</label>
            <input type="text" class="form-control" name="scaledActivity" id="" aria-describedby="helpId"
                placeholder="">
            @error('scaledActivity')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <button class="btn btn-primary mt-2" type="submit">Toevoegen</button>
        </div>


    </form>

    <form action="{{ route('clientActivities.destroy') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group row">
            <label>Selecteer te verwijderen activiteit:</label>
            <select class="form-control" name="removeActivity">
                @foreach ($activities as $activity)
                    @if ($activity->type == 'main')
                        <option value="{{ $activity->id }}">{{ $activity->value }}</option>
                    @endif
                @endforeach
            </select>
            <button class="btn btn-primary mt-2" type="submit">Verwijder</button>

        </div>

    </form>

    <form action="{{ route('clientActivities.store') }}" method="post">
        @csrf

        <div class="form-group row">
            <label for="">Toevoegen nieuwe activiteit</label>
            <input type="text" class="form-control" name="mainActivity" id="" aria-describedby="helpId"
                placeholder="">
            @error('mainActivity')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

        </div>
        <div class="row">
            <button class="btn btn-primary mt-2" type="submit">Toevoegen</button>
        </div>
    </form>



@endsection
