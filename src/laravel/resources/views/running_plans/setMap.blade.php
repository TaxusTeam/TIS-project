@extends('app', 'Map save')


@section('content')

    <?php
    Session::set("aa", $_POST["aa"]);
    Session::set("bb", $_POST["bb"]);
    Session::set("cc", $_POST["cc"]);
    ?>

@endsection