@extends('web.layout.navbar')

@section('content')
    <h3>web.client.logger.index.blade.php</h3>
    {{ $dailyQuestions }}
    @foreach ($dailyQuestions as $dailyQuestion)
        <div class="row">
            <div class="col-2">
                {{ $dailyQuestion->created_at->locale('nl')->format('d-m-Y')}}
            </div>
            <div class="col-2">
                @if ($dailyQuestion->created_at->isToday())
                    Vandaag
                @else
                    {{ $dailyQuestion->created_at->locale('nl')->dayName }}
                @endif

            </div>
            <div class="col-2">
                @if ($dailyQuestion->created_at == $dailyQuestion->updated_at)
                    nog niet ingevuld
                @else
                    @if ($dailyQuestion->filled == false)
                        nog niet compleet
                    @else
                        compleet
                    @endif
                @endif

            </div>
        </div>
    @endforeach
@endsection
