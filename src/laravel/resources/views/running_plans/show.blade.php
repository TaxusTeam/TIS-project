@extends('app')
@section('title', $title)


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Bežecký plán</div>
                <div class="panel-body">
                    <div class="row running-plans">
                        <div class="col-xs-12 running-plans__div--detail rp-list">
                            @if(Auth::user()->is_trainer)
                                @if($timeAtomaticlalyAdjusted)
                                    <h2 class="rp__h2--date-error">Nastavili ste nesplniteľný časový rozsah plánu, preto bol automaticky upravený</h2>
                                    {{ Session::put('timeAtomaticlalyAdjusted', false) }}
                                @endif
                            @endif

                            <div class="row rp-box">
                                <div class="col-xs-12 rp-box__row--header">
                                    <div class="rp-box__header--name">
                                        {{ $runningPlan->name }}
                                    </div>
                                    <div class="rp-box__header--distance_text">
                                        {{ $runningPlan->distance_text }}
                                    </div>
                                </div>

                                <div class="col-xs-12 rp-box__detail--wrapper">
                                    <div class="row">

                                        <div class="col-xs-12 rp-box__row--description">
                                            {{ $runningPlan->description }}
                                        </div>

                                        {!!  Form::model($runningPlan, ['class' => 'form--label-bold form--detail']) !!}

                                        <div class="col-xs-12">
                                            <div class="row">

                                                <div class="div--vertical-space col-xs-12"></div>

                                                {!! Form::label('start', 'Začiatok&nbsp;plánu: ', ["class" => "col-xs-12 col-sm-3"]) !!}
                                                {!! Form::text('start', date("d. m. Y", strtotime($runningPlan->start)), [
                                                    "class" => "col-xs-12 col-sm-9",
                                                    "disabled" => "disabled"
                                                ]) !!}

                                                {!! Form::label('end', 'Koniec&nbsp;plánu: ', ["class" => "col-xs-12 col-sm-3"]) !!}
                                                {!! Form::text('end', date("d. m. Y", strtotime($runningPlan->end)), [
                                                    "class" => "col-xs-12 col-sm-9",
                                                    "disabled" => "disabled"
                                                ]) !!}

                                                <div class="div--vertical-space col-xs-12"></div>

                                                {!! Form::label('origin', 'Štart:', ["class" => "col-xs-12 col-sm-3"]) !!}
                                                {!! Form::text('origin', null, [
                                                    "class" => "col-xs-12 col-sm-9",
                                                    "disabled" => "disabled"
                                                ]) !!}

                                                {!! Form::label('destination', 'Cieľ:', ["class" => "col-xs-12 col-sm-3"]) !!}
                                                {!! Form::text('destination', null, [
                                                    "class" => "col-xs-12 col-sm-9",
                                                    "disabled" => "disabled"
                                                ]) !!}

                                                <div class="div--vertical-space col-xs-12"></div>

                                            </div>
                                        </div>

                                        {!!  Form::close() !!}

                                        <div class="col-xs-12 div--map map--show">
                                            <div class="row">
                                                @include('running_plans.showMap')
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xs-12 rp-box__row--group">
                                    <div class="rp-box__header--name">
                                        skupina: <span class="rp-box__span--group">{{ $groups[ $runningPlan->group_id ] }}</span>
                                    </div>
                                    <div class="rp-box__header--distance_text">
                                        <span class="rp-box__span--group">{{ $runningPlan->distance_text }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xs-12 runners">
                            <h2 class="h2">Prihlásení bežci</h2>

                            @forelse($runners as $runner)
                                @include('running_plans.runner_info_box')
                            @empty
                                <div class="row rp-box">
                                    <div class="col-xs-12">
                                        Zatiaľ sa neprihlásil žiaden bežec.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if(Auth::user()->is_trainer)
                            <div class="col-xs-12">
                                {!!  Form::open(['route' => ['running_plan.destroy', $runningPlan->id], 'method' => 'delete','class' => 'form--label-bold']) !!}

                                <div class="row">

                                    <div class="col-xs-12 wrapper--check-box">
                                        {!! Form::label('check', 'Nenávratne vymazať plán:', ['class' => 'label--delete']) !!}
                                        {!! Form::checkbox('check', null, false, ['class' => 'label--delete']) !!}
                                    </div>

                                    {!!  Form::submit('Vymazať plán', [
                                        "class" => "col-xs-12 js_delete_rp"
                                    ]) !!}

                                </div>

                                {!!  Form::close() !!}

                            </div>
                        @elseif($theme_background != "theme_old")
                            <div class="col-xs-12">
                                @if($theme_background == "theme_future")

                                    {!!  Form::open(['url' => 'user_running_plan', 'method' => 'post','class' => 'form--label-bold']) !!}

                                @elseif($theme_background == "theme_current")

                                    {!!  Form::open(['route' => ['user_running_plan.destroy', $runningPlan->id], 'method' => 'delete','class' => 'form--label-bold']) !!}

                                @endif



                                <div class="row">

                                    {!! Form::hidden('running_plan_id', $runningPlan->id) !!}

                                    @if($theme_background == "theme_future")

                                        {!!  Form::submit('Prihlásiť sa na plán', [
                                            "class" => "col-xs-12 rp__button--sign-in"
                                        ]) !!}

                                    @elseif($theme_background == "theme_current")

                                        {!!  Form::submit('Odhlásiť sa z plánu', [
                                            "class" => "col-xs-12 rp__button--sign-out"
                                        ]) !!}

                                    @endif



                                </div>

                                {!!  Form::close() !!}

                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".rp-box__row--header").addClass("{{ $theme_background }}");

        @if(Auth::user()->is_trainer)
            $(".js_delete_rp").hide();

            $("#check").change(function () {
                $(".js_delete_rp").toggle(500);
            });
        @endif
    });
</script>

@endsection