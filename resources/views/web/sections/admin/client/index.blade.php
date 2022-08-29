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
                <th>Account status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
            <tr>

            <td>{{ $client->firstname }}</td>
            <td>{{ $client->lastname }}</td>
            <td>{{ $client->user->email }}</td>
            <td>        @if ($client->user->account_status)
                active
            @else
                non-active
            @endif</td>
    
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $clients->links() }}

    
 

  
    {{-- @foreach ($dailyActivities as $dailyActivity)
    <div class="row">
        <a href="{{ route('dailyActivity.edit', ['user_id' => Auth::id(),'daily_activity_id'=>$dailyActivity->id]) }}" class="link-secondary"
            >{{ $dailyActivity->date_today }}</a>

    </div>
    
    @endforeach --}}



@endsection
