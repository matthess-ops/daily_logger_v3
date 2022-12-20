@extends('web.layout.navbar')

@section('content')

    {{-- <h3>web.admin.client.index.blade.php</h3> --}}
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Clienten</h5>
        </div>
    </div>



    <form action="{{ route('client.index')}}" method="GET">
        <div class="row ">
            <div class="col-lg-3 col-sm-12 mb-1">
                <input class="w-100"type="text" name="search"
                />

            </div>
            <div class="col-lg-2 col-sm-12 mb-1">
                <button type="submit" class="btn btn-primary w-100 btn-sm">Zoek</button>

            </div>
        </div>

    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th class="d-none d-md-table-cell">Email</th>
                <th class="d-none d-md-table-cell">Account aangemaakt</th>

                <th>Account status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr onclick="location.href='{{ route('client.show', ['client_id' => $client->id]) }}'">

            {{-- <tr onclick="location.href='{{ route('client.show'), ['id' => $client->id]) }}'"> --}}

            <td>{{ $client->firstname }}</td>
            <td>{{ $client->lastname }}</td>
            <td class="d-none d-md-table-cell">{{ $client->user->email }}</td>
            <td class="d-none d-md-table-cell">{{ $client->user->created_at->format('M d Y') }}</td>

            {{-- <td>{{$client->user->active}}</td> --}}
            <td>        @if ($client->user->active == true)
                actief
            @else
                gedeactiveerd
            @endif</td>

            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $clients->links() }}






@endsection
