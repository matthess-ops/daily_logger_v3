@extends('web.layout.navbar')

@section('content')
    <h3>web.client.activity.index.blade.php</h3>
    <form action="{{ route('clientActivities.destroy') }}"method="POST">
        @csrf
        @method('DELETE')
        <div class="form-group row">
            <label>Remove scaled activity</label>
            <select class="form-control" name="removeScaled">
                @foreach ($activities as $activity)
                @if ($activity->type == 'scaled')
                <option value = "{{$activity->id}}">{{$activity->value}}</option>

                @endif

                @endforeach
            </select>
            <button class="btn btn-primary mt-2" type="submit" >remove</button>

        </div>

    </form>

    <form action="{{ route('clientActivities.destroy') }}" method="POST">
        @csrf
        @method('DELETE')

        <div class="form-group row">
            <label>Remove main activity</label>
            <select class="form-control" name="removeMain">
                @foreach ($activities as $activity)
                @if ($activity->type == 'main')
                <option value = "{{$activity->id}}">{{$activity->value}}</option>

                @endif

                @endforeach
            </select>
            <button class="btn btn-primary mt-2" type="submit" >remove</button>

        </div>

    </form>



@endsection
