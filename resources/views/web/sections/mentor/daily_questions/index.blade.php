@extends('web.layout.navbar')

@section('content')

    <h3>web.mentor.report.index.blade.php</h3>
    {{-- {{ json_encode($dailyQuestions) }} --}}
    {{-- @foreach ($dailyQuestions as $dailyQuestion)
        {{ $dailyQuestion->client->firstname }}
    @endforeach --}}

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

                <th>Client filled</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($dailyQuestions as $dailyQuestion)
            <tr onclick="location.href='{{ route('mentor.dailyquestion.edit', ['question_id' => $dailyQuestion->id]) }}'">


            <td>{{ $dailyQuestion->client->firstname}}</td>
            <td>{{ $dailyQuestion->client->lastname}}</td>
            <td>{{ $dailyQuestion->client->user->email }}</td>
            <td>{{ $dailyQuestion->created_at->format('M d Y') }}</td>

            {{-- <td>{{$client->user->active}}</td> --}}
            <td>        @if ($dailyQuestion->filled == true)
                filled
            @else
                non-filled
            @endif</td>

            </tr>
        @endforeach
        </tbody>
    </table>



@endsection
