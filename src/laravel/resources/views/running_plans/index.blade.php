@extends('app')
@section('title', 'DB save')


@section('content')

    {{ $_COOKIE["totalDistanceText"] }}
    {{ $_COOKIE["totalDistanceValue"] }}
    {{ $_COOKIE["geoLocationOriginLat"] }}
    {{ $_COOKIE["geoLocationOriginLng"] }}
    {{ $_COOKIE["geoLocationDestinationLat"] }}
    {{ $_COOKIE["geoLocationDestinationLng"] }}

@endsection