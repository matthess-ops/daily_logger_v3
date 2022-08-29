@extends('web.layout.navbar')

@section('content')

    <h3>web.client.daily_activities.index.blade.php</h3>
    @foreach ($dailyActivities as $dailyActivity)
    <div class="row">
        <a href="{{ route('dailyActivity.edit', ['user_id' => Auth::id(),'daily_activity_id'=>$dailyActivity->id]) }}" class="link-secondary"
            >{{ $dailyActivity->date_today }}</a>

    </div>
    
    @endforeach



@endsection
