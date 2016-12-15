@extends('app', 'Map save')


@section('content')

    "totalDistanceText = ..." {{ Session::get("aa") }}
    "totalDistanceValue = ..." . {{ Session::get("bb") }}
    "totalGeoLocationsLength = ..." . {{ Session::get("cc") }}

@endsection