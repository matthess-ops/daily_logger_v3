@extends('web.layout.navbar')

@section('content')

    {{-- <h3>web.mentor.report.index.blade.php</h3>
   <ul>
    <li>kan natuurlijk zijn dat clienten niet elke dat aanwezig zijn dus een optie inbouwen om te zeggen dat de client er niet is</li>
   <li>kan het ook op een andere manier doen, van dat een mentor een client moet opzoeken om dan een dagelijkse rapportage aan te maken/ in te vullen. Echter dit is natuurlijk wel meer werk voor de mentor. En het probleem is als er meerdere mentors aanwezig zijn het niet overzichtelijk is als een andere mentor de dag rapportage al heeft gedaan</li>
<li>op het moment staan hier ook al de niet ingevulde dag rapportage. Zo houden of alleen limiteren tot een aantal dagen?</li>
</ul> --}}



{{-- <h4>Dagelijkse waardering rapporten die nog open staan.</h4> --}}
<div class="row mb-2">
    <div class="col">
        <h5 class="font-weight-bold">Dagelijkse rapporten die open staan</h5>
    </div>
</div>

    <form action="{{ route('mentor.dailyquestion.index')}}" method="GET">
        <div class="row ">
            <div class="col-lg-3 col-sm-12 mb-1">
                <input class="w-100"type="text" name="search"
                />
                {{-- <input class="w-100"type="text" name="search"
                @isset($searchQuery) value= "{{ $searchQuery }}" @endisset /> --}}
            </div>
            <div class="col-lg-2 col-sm-12 mb-1">
                <button type="submit" class="btn btn-primary w-100 btn-sm">Zoek</button>

            </div>
        </div>

    </form>

    <div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th class="d-none d-md-table-cell">Email</th>
                <th>Raport datum</th>

                {{-- <th>Client filled</th> --}}

            </tr>
        </thead>
        <tbody>
            @foreach ($dailyQuestions as $dailyQuestion)
            <tr onclick="location.href='{{ route('mentor.dailyquestion.edit', ['question_id' => $dailyQuestion->id]) }}'">


            <td>{{ $dailyQuestion->client->firstname}}</td>
            <td>{{ $dailyQuestion->client->lastname}}</td>
            <td class="d-none d-md-table-cell">{{ $dailyQuestion->client->user->email }}</td>
            <td>{{ $dailyQuestion->created_at->locale('nl')->translatedFormat('l d M Y') }}</td>

            {{-- <td>        @if ($dailyQuestion->filled == true)
                filled
            @else
                non-filled
            @endif</td> --}}

            </tr>
        @endforeach
        </tbody>
    </table>
</div>


@endsection
