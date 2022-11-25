@extends('web.layout.navbar')

@section('content')

    <h3>web.mentor.report.index.blade.php</h3>
   <ul>
    <li>kan natuurlijk zijn dat clienten niet elke dat aanwezig zijn dus een optie inbouwen om te zeggen dat de client er niet is</li>
   <li>kan het ook op een andere manier doen, van dat een mentor een client moet opzoeken om dan een dagelijkse rapportage aan te maken/ in te vullen. Echter dit is natuurlijk wel meer werk voor de mentor. En het probleem is als er meerdere mentors aanwezig zijn het niet overzichtelijk is als een andere mentor de dag rapportage al heeft gedaan</li>
<li>op het moment staan hier ook al de niet ingevulde dag rapportage. Zo houden of alleen limiteren tot een aantal dagen?</li>
</ul>

<h4>Dagelijkse waardering rapporten die nog open staan.</h4>

    <form action="{{ route('mentor.dailyquestion.index')}}" method="GET">
        <input type="text" name="search"
            @isset($searchQuery) value= "{{ $searchQuery }}" @endisset />
        <button type="submit" class="btn btn-primary">Zoek</button>
    </form>


    <table class="table table-hover">
        <thead>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th>Raport datum</th>

                {{-- <th>Client filled</th> --}}

            </tr>
        </thead>
        <tbody>
            @foreach ($dailyQuestions as $dailyQuestion)
            <tr onclick="location.href='{{ route('mentor.dailyquestion.edit', ['question_id' => $dailyQuestion->id]) }}'">


            <td>{{ $dailyQuestion->client->firstname}}</td>
            <td>{{ $dailyQuestion->client->lastname}}</td>
            <td>{{ $dailyQuestion->client->user->email }}</td>
            <td>{{ $dailyQuestion->created_at->format('M d Y') }}</td>

            {{-- <td>        @if ($dailyQuestion->filled == true)
                filled
            @else
                non-filled
            @endif</td> --}}

            </tr>
        @endforeach
        </tbody>
    </table>



@endsection
