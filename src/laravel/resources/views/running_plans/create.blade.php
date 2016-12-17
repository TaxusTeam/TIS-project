@extends('app')
@section('title', $title)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Auth::user()->is_trainer)
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
                                {!!  Form::open(['url' => 'running_plan', 'method' => 'post','class' => 'form--label-bold']) !!}

                                <div class="row">

                                    {!! Form::label('name', 'Názov:', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    {!! Form::text('name', null, [
                                        'placeholder' => 'názov bežeckého plánu',
                                        "class" => "col-xs-12 col-sm-9",
                                        "required" => "true"
                                    ]) !!}

                                    {!! Form::label('description', 'Popis:', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    {!! Form::textarea('description', null, [
                                        'placeholder' => 'popis bežeckého plánu',
                                        'rows' => 5,
                                        "class" => "col-xs-12 col-sm-9"
                                    ]) !!}

                                    {!! Form::label('group_id', 'Vyber skupinu: ', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    <div class="col-xs-12 col-sm-9 div--no-padding">
                                        {!! Form::select('group_id', $groups) !!}
                                    </div>

                                    <div class="div--vertical-space col-xs-12"></div>

                                    {!! Form::label('start', 'Začiatok plánu: ', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    {!! Form::text('start', null, [
                                        'placeholder' => 'Časový začiatok plánu',
                                        "class" => "col-xs-12 col-sm-9",
                                        "required" => "true"
                                    ]) !!}

                                    {!! Form::label('end', 'Koniec plánu: ', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    {!! Form::text('end', null, [
                                        'placeholder' => 'Časový koniec plánu',
                                        "class" => "col-xs-12 col-sm-9",
                                        "required" => "true"
                                    ]) !!}

                                    <div class="div--vertical-space col-xs-12"></div>

                                    {!! Form::label('origin', 'Štart:', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    {!! Form::text('origin', null, [
                                        'placeholder' => 'Štart bežeckého plánu',
                                        "class" => "col-xs-12 col-sm-9"
                                    ]) !!}

                                    {!! Form::label('destination', 'Cieľ:', ["class" => "col-xs-12 col-sm-3"]) !!}
                                    {!! Form::text('destination', null, [
                                        'placeholder' => 'Cieľ bežeckého plánu',
                                        "class" => "col-xs-12 col-sm-9"
                                    ]) !!}



                                    {!!  Form::submit('Uložiť plán', [
                                        'disabled' => 'disabled',
                                        "class" => "col-xs-12"
                                    ]) !!}

                                </div>

                                {!!  Form::close() !!}
                            @else
                                <p>Najskôr vytvorte nejakú skupinu prosím, aby ste jej mohli vytvoriť bežecký plán</p>
                            @endif
                        </div>
                        <div class="panel-body div--map">
                            @include('running_plans.createMap')
                        </div>
                    </div>
                @else
                    {{ /*abort(403, "Nie ste tréner.")*/ view("errors/403") }}
                @endif
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