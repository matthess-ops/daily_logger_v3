@extends('web.layout.navbar')

@section('content')

    <h3>web.admin.client.index.blade.php</h3>
    authorize fixen

    <form action="{{ route('client.index')}}" method="GET">
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
                <th>Account aangemaakt</th>

                <th>Account status</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr onclick="location.href='{{ route('client.show', ['client_id' => $client->id]) }}'">

            {{-- <tr onclick="location.href='{{ route('client.show'), ['id' => $client->id]) }}'"> --}}

            <td>{{ $client->firstname }}</td>
            <td>{{ $client->lastname }}</td>
            <td>{{ $client->user->email }}</td>
            <td>{{ $client->user->created_at->format('M d Y') }}</td>

            {{-- <td>{{$client->user->active}}</td> --}}
            <td>        @if ($client->user->active == true)
                active
            @else
                non-active
            @endif</td>

            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $clients->links() }}






@endsection
