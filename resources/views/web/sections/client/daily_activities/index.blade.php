@extends('web.layout.navbar')

@section('content')

    <h3>web.client.daily_activities.index.blade.php</h3>
    {{ $dailyActivities }}
    @foreach ($dailyActivities as $dailyActivity)
    <div class="row">
        <a href="{{ route('dailyActivity.edit', ['user_id' => Auth::id(),'daily_activity_id'=>$dailyActivity->id]) }}" class="link-secondary"   
            >{{ $dailyActivity->date_today }}</a>

    </div>
    {{ $dailyActivity->created_at == $dailyActivity->updated_at? 'link-warning ' : 'link-primary' }}
    bah{{ $dailyActivity->created_at == $dailyActivity->updated_at? 'link-warning ' : 'link-primary' }}

    {{-- <a href="{{ route('dailyActivity.edit',['user_id'=>Auth::id(),'daily_activity_id'=>$dailyActivity->$id]) }}" class="link-primary">{{ $dailyActivity->date_today }}</a> --}}
    {{-- {user_id}/{daily_activity_id} --}}
        
    @endforeach
    


@endsection
