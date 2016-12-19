@extends('app')
@section('title', $title)


@section('content')

    @if($check)
        @if(Auth::user()->is_trainer)
            trener

            {{ $runningPlan }}

            @if($timeAtomaticlalyAdjusted)
                <h1>Datum bol nastaveny si borec</h1>
                {{ Session::put('timeAtomaticlalyAdjusted', false) }}
            @endif
        @else
            bezec TODO check

            {{ $runningPlan }}
        @endif
    @else
        {{ /*abort(403)*/ view("errors/403") }}
    @endif

@endsection