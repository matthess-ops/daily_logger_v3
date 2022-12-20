@extends('web.layout.navbar')

@section('content')
    {{-- <h3>web.admin.client.show.blade.php</h3> --}}
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Clienten config</h5>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col">
            <h6 class="">Client account gegevens</h6>
        </div>
    </div>

    <span>{{ $client->firstname }} {{ $client->lastname }}</span> <br>
    <span>{{ $client->street }} {{ $client->street_nr }} </span> <br>
    <span>{{ $client->postcode }} {{ $client->city }} </span> <br>
    <span>{{ $client->user->email }} </span> <br>
    <span>{{ $client->phone_number }} </span> <br>

    <hr>
    <div class="row">
        <div class="col">
            <h6 class="">Activiteiten logger duratie</h6>
        </div>
    </div>

    <form action="{{ route('clientWorkTime.update', ['client_id' => $client->id]) }}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                @if ($client->activity_time == '24hour')
                    <input type="hidden" name="timeState" value="toWorkDay">

                    <button type="submit" class="btn btn-primary w-100">Zet naar 8 uur</button>
                @else
                    <input type="hidden" name="timeState" value="to24Hour">
                    <button type="submit" class="btn btn-primary w-100">Zet naar 24 uur</button>
                @endif


            </div>
        </div>

    </form>


    <hr>
    <div class="row">
        <div class="col">
            <h6 class="">Verander account status</h6>
        </div>
    </div>

    <form action="{{ route('client.update', ['client_id' => $client->id]) }}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                @if ($client->user->active)
                    <button type="submit" class="btn btn-primary w-100">Deactiveer account</button>
                @else
                    <button type="submit" class="btn btn-primary w-100">Activeer account</button>
                @endif
            </div>
        </div>
    </form>

    <hr>
    <div class="row">
        <div class="col">
            <h6 class="">Dagelijkse vragen van client</h6>
        </div>
    </div>
    @foreach ($client->questions as $question)
        <div class="row">
            <div class="col-1">
                {{ $loop->index }}
            </div>
            <div class="col-11">
                {{ $question->question }}
            </div>
        </div>
    @endforeach
    <div class="row">

        <div class="col-lg-3 col-sm-12">
            <a name="" id="" class="btn btn-primary w-100"
                href="{{ route('question.edit', ['client_id' => $client->id]) }}" role="button">Vragen aanpassen</a>
        </div>
    </div>
@endsection
