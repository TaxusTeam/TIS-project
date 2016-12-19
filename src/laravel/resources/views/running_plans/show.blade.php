@extends('app')
@section('title', 'DB save')


@section('content')

    {{ $runningPlan }}
    {{ "show " . $timeAtomaticlalyAdjusted . "END show" }}

    {{ dump($timeAtomaticlalyAdjusted) }}

@endsection