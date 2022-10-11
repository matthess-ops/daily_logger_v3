@extends('web.layout.navbar')

@section('content')
    <h3>web.client.daily_activities.index.blade.php</h3>
    <h3>test</h3>
    <div class="container">

    @foreach ($dailyActivities as $dailyActivity)
        <div class="row">
            <div class="col-12">
                <a href="{{ route('dailyActivity.edit', ['user_id' => Auth::id(), 'daily_activity_id' => $dailyActivity->id]) }}"
                    class="link-secondary">{{ $dailyActivity->date_today }}</a>

            </div>

        </div>
    @endforeach
</div>

@endsection
