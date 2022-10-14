@extends('web.layout.navbar')

@section('content')
    <h3>web.client.daily_activities.index.blade.php</h3>
    <ul>
        <li>Stel voor de laatste 5 dagen van de activiteiten logger hier te plaatsen.Dan kan een client nog altijd iets aanpassen.</li>
    <li>iets inbouwen zodat de client kan zien dat er nog timeslots zijn die nog niet helemaal zijn ingevuld</li>
    </ul>
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
