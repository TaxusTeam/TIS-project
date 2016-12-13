@extends('app')
@section('title', $title)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Vytvorenie bežeckého plánu</div>
                    <div class="panel-body">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                        @if(!empty($groups))
                            {!!  Form::open(['url' => 'running_plan', 'method' => 'post']) !!}

                                {!! Form::label('name', 'Názov:') !!}
                                {!! Form::text('name', null, [
                                    'placeholder' => 'názov bežeckého plánu'
                                ]) !!}

                                {!! Form::label('description', 'Popis:') !!}
                                {!! Form::textarea('description', null, [
                                    'placeholder' => 'popis bežeckého plánu',
                                    'rows' => 5
                                ]) !!}

                                {!! Form::label('group_id', 'Vyber skupinu: ') !!}
                                {!! Form::select('group_id', $groups) !!}



                                {!! Form::label('start', 'Začiatok plánu: ') !!}
                                {!! Form::text('start', null, [
                                    'placeholder' => 'Časový začiatok plánu'
                                ]) !!}

                                {!! Form::label('end', 'Koniec plánu: ') !!}
                                {!! Form::text('end', null, [
                                    'placeholder' => 'Časový koniec plánu'
                                ]) !!}

                                {!! Form::label('origin', 'Štart:') !!}
                                {!! Form::text('origin', null, [
                                    'placeholder' => 'Štart bežeckého plánu'
                                ]) !!}

                                {!! Form::label('destination', 'Cieľ:') !!}
                                {!! Form::text('destination', null, [
                                    'placeholder' => 'Cieľ bežeckého plánu'
                                ]) !!}



                                {!!  Form::submit('Uložiť plán', [
                                    'disabled' => 'true'
                                ]) !!}

                            {!!  Form::close() !!}

                            @include('running_plans.createMap')
                        @else
                            <p>Najskôr vytvorte nejakú skupinu prosím, aby ste jej mohli vytvoriť bežecký plán</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            ( function( factory ) {
                if ( typeof define === "function" && define.amd ) {

                    // AMD. Register as an anonymous module.
                    define( [ "../widgets/datepicker" ], factory );
                } else {

                    // Browser globals
                    factory( jQuery.datepicker );
                }
            }( function( datepicker ) {

                datepicker.regional.sk = {
                    closeText: "Zavrieť",
                    prevText: "&#x3C;Predchádzajúci",
                    nextText: "Nasledujúci&#x3E;",
                    currentText: "Dnes",
                    monthNames: [ "január","február","marec","apríl","máj","jún",
                        "júl","august","september","október","november","december" ],
                    monthNamesShort: [ "Jan","Feb","Mar","Apr","Máj","Jún",
                        "Júl","Aug","Sep","Okt","Nov","Dec" ],
                    dayNames: [ "nedeľa","pondelok","utorok","streda","štvrtok","piatok","sobota" ],
                    dayNamesShort: [ "Ned","Pon","Uto","Str","Štv","Pia","Sob" ],
                    dayNamesMin: [ "Ne","Po","Ut","St","Št","Pia","So" ],
                    weekHeader: "Ty",
                    dateFormat: "dd.mm.yy",
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: "" };
                datepicker.setDefaults( datepicker.regional.sk );

                return datepicker.regional.sk;

            } ) );

            $("#start").datepicker();
            $("#end").datepicker();
        });
    </script>

@endsection