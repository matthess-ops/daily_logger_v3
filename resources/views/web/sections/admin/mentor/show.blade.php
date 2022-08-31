@extends('web.layout.navbar')

@section('content')

    <h3>web.admin.mentor.show.blade.php</h3>


    <span>{{ $mentor->firstname }} {{ $mentor->lastname }}</span> <br>
    <span>{{ $mentor->street }} {{ $mentor->street_nr }} </span> <br>
    <span>{{ $mentor->postcode }} {{ $mentor->city }} </span> <br>
    <span>{{ $mentor->user->email }} </span> <br>
    <span>{{ $mentor->phone_number }} </span> <br><br>

    @if ($mentor->user->active)
    <form action="{{route('mentor.update',['mentor_id'=>$mentor->id])}}" method="POST">
       @csrf
       {{ method_field('patch') }}
       <button type="submit" class="btn btn-primary">Deactiveer account</button>
    </form>


    @else
    <form action="{{route('mentor.update',['mentor_id'=>$mentor->id])}}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <button type="submit" class="btn btn-primary">Activeer account</button>
     </form>
    @endif





@endsection
