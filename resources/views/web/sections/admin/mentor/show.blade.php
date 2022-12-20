@extends('web.layout.navbar')

@section('content')

<div class="row mb-2">
    <div class="col">
        <h5 class="font-weight-bold">Mentor config</h5>
    </div>
</div>
<hr>

<div class="row">
    <div class="col">
        <h6 class="">Account gegevens begeleider</h6>
    </div>
</div>

    <span>{{ $mentor->firstname }} {{ $mentor->lastname }}</span> <br>
    <span>{{ $mentor->street }} {{ $mentor->street_nr }} </span> <br>
    <span>{{ $mentor->postcode }} {{ $mentor->city }} </span> <br>
    <span>{{ $mentor->user->email }} </span> <br>
    <span>{{ $mentor->phone_number }} </span>

    <hr>
    <div class="row">
        <div class="col">
            <h6 class="">Verander account status</h6>
        </div>
    </div>

    <form action="{{ route('mentor.update', ['mentor_id' => $mentor->id]) }}" method="POST">
        @csrf
        {{ method_field('patch') }}
        <div class="row">
            <div class="col-lg-3 col-sm-12">
                @if ($mentor->user->active)
                    <button type="submit" class="btn btn-primary w-100">Deactiveer account</button>
                @else
                    <button type="submit" class="btn btn-primary w-100">Activeer account</button>
                @endif
            </div>
        </div>
    </form>

    {{-- @if ($mentor->user->active)
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
    @endif --}}





@endsection
