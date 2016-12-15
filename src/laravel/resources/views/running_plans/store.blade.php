@extends('app')
@section('title', 'DB save')


@section('content')

    <script>
        var a = localStorage.totalDistanceText;
        var b = localStorage.totalDistanceValue;
        var c = localStorage.totalGeoLocationsLength;

        $.post("{!! url('running_planSetMap') !!}", {
            aa: a,
            bb: b,
            cc: c
        }, function (data) {
            alert("ok");
        }).fail(function()
        {
            alert("Damn, something broke");
        });

    </script>

@endsection