@extends('web.layout.navbar')

@section('content')
    <div class="row mb-2">
        <div class="col">
            <h5 class="font-weight-bold">Begeleiders</h5>
        </div>
    </div>




    <form action="{{ route('mentor.index') }}" method="GET">
        {{-- <input type="text" name="search" @isset($searchQuery) value= "{{ $searchQuery }}" @endisset />
        <button type="submit" class="btn btn-primary">Zoek</button> --}}
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
            @foreach ($mentors as $mentor)
                <tr onclick="location.href='{{ route('mentor.show', ['mentor_id' => $mentor->id]) }}'">


                    <td>{{ $mentor->firstname }}</td>
                    <td>{{ $mentor->lastname }}</td>
                    <td  class="d-none d-md-table-cell">{{ $mentor->user->email }}</td>
                    <td  class="d-none d-md-table-cell">{{ $mentor->user->created_at->format('M d Y') }}</td>

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
