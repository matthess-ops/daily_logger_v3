@extends('web.layout.navbar')

@section('content')
    <h3>web.client.logger.index.blade.php</h3>
    <ul>
        <li>werkt dit</li>
    </ul>
    @foreach ($dailyQuestions as $dailyQuestion)
        <div class="row">
            {{ 'dailyquest s/c ' . json_encode($dailyQuestion->started).json_encode($dailyQuestion->completed) }}
            {{ 'dailyact s/c ' . json_encode($dailyActivities[$loop->index]->started).json_encode($dailyActivities[$loop->index]->completed) }}
            {{-- {{ 'dailyquest completed ' . json_encode($dailyQuestion->completed) }}
            {{ 'dailyact completed ' . json_encode($dailyActivities[$loop->index]->completed) }} --}}
            <div class="col-2">
                {{ $dailyQuestion->created_at->locale('nl')->format('d-m-Y') }}
            </div>
            <div class="col-2">
                @if ($dailyQuestion->created_at->isToday())
                    Vandaag
                @else
                    {{ $dailyQuestion->created_at->locale('nl')->dayName }}
                @endif

            </div>
            <div class="col-2">
                @if ($dailyQuestion->started ==false and $dailyActivities[$loop->index]->started ==false)
                    Nog invullen
                @else
                    @if ($dailyQuestion->completed and $dailyActivities[$loop->index]->completed)
                        Compleet
                    @else
                        @if ($dailyQuestion->completed == false or $dailyActivities[$loop->index]->completed == false)
                            Verder afmaken
                        @else
                        @endif
                    @endif
                @endif

                {{-- {{$dailyQuestion->date_today}}
                {{$dailyActivities[$loop->index]->date_today}} --}}
            </div>
            {{-- <div class="col-2">
                @if ($dailyQuestion->created_at == $dailyQuestion->updated_at)
                    nog niet ingevuld
                @else
                    @if ($dailyQuestion->filled == false)
                        nog niet compleet
                    @else
                        compleet
                    @endif
                @endif

            </div> --}}

            <div class="col-2">
                <a name="" id="" class="btn btn-primary"
                    href="{{ route('log.edit', ['user_id' => Auth::id(), 'date' => $dailyQuestion->created_at]) }}"
                    role="button">Ga naar</a>
            </div>
        </div>
    @endforeach


@endsection
