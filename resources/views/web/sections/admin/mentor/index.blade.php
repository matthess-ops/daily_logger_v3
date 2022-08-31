@extends('web.layout.navbar')

@section('content')
    <h3>
        web.admin.mentor.index.blade.php</h3>




    <form action="{{ route('mentor.index') }}" method="GET">
        <input type="text" name="search" @isset($searchQuery) value= "{{ $searchQuery }}" @endisset />
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
            @foreach ($mentors as $mentor)
                <tr onclick="location.href='{{ route('mentor.show', ['mentor_id' => $mentor->id]) }}'">


                    <td>{{ $mentor->firstname }}</td>
                    <td>{{ $mentor->lastname }}</td>
                    <td>{{ $mentor->user->email }}</td>
                    <td>{{ $mentor->user->created_at->format('M d Y') }}</td>

                    {{-- <td>{{$client->user->active}}</td> --}}
                    <td>
                        @if ($mentor->user->active == true)
                            active
                        @else
                            non-active
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $mentors->links() }}
@endsection
