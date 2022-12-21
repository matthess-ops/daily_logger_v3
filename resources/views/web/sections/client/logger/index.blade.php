@extends('web.layout.navbar')

@section('content')
    {{-- <h3>web.client.logger.index.blade.php</h3> --}}
    <div class="container">
        @if ($dailyQuestions->toArray() == null or $dailyActivities->toArray() == null)
            <div class="row  mb-1">
                <div class="col-12">
                    <h5>Er zijn voor deze week geen activiteiten en dag rapportages aangemaakt. Indien u denkt dat dit niet
                        klopt, neem dan contact op met uw begeleider.</h5>

                </div>
            </div>
        @else
            <div class="row mb-1">
                <div class="col-12">
                    <h5>Overzicht van dagelijkse activiteiten/dag rapportages</h5>

                </div>

            </div>
            @foreach ($dailyQuestions as $dailyQuestion)
                <div class="row">
                    <div class="col-lg-6 ">
                        <div class="row">
                            <div class="col-6 ">
                                {{ $dailyQuestion->created_at->locale('nl')->format('d-m-Y') }}
                            </div>
                            <div class="col-6">
                                @if ($dailyQuestion->created_at->isToday())
                                    Vandaag
                                @else
                                    {{ $dailyQuestion->created_at->locale('nl')->dayName }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ">
                        <div class="row">

                            <div class="col-6 ">
                                @if ($dailyQuestion->started == false and $dailyActivities[$loop->index]->started == false)
                                    Nog invullen
                                @else
                                    @if ($dailyQuestion->completed and $dailyActivities[$loop->index]->completed)
                                        Compleet
                                    @else
                                        @if ($dailyQuestion->completed == false or $dailyActivities[$loop->index]->completed == false)
                                            Verder afmaken
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="col-6 ">
                                <a name="" id="" class="btn btn-primary btn-sm"
                                    href="{{ route('log.edit', ['user_id' => Auth::id(), 'date' => $dailyQuestion->created_at]) }}"
                                    role="button">Open logger</a>
                            </div>
                        </div>

                    </div>
                </div>
                <hr />
            @endforeach
        @endif
    </div>


@endsection
