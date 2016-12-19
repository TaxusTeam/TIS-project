@extends('app')
@section('title', $title)


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Zoznam bežeckých plánov</div>
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



                    <div class="row running-plans">
                        <div class="col-xs-12 running-plans__div--current rp-list">
                            <h2>Aktuálne plány</h2>

                            @forelse($runningPlansCurrent as $runningPlan)
                                @include('running_plans.running_plan_box')
                            @empty
                                <div class="row rp-box">
                                    <div class="col-xs-12">
                                        Momentálne neprebiehajú žiadne plány.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="col-xs-12 col-sm-6 col-sm-push-6 running-plans__div--future rp-list">
                            <h2>Budúce plány</h2>

                            @forelse($runningPlansFuture as $runningPlan)
                                @include('running_plans.running_plan_box')
                            @empty
                                <div class="row rp-box">
                                    <div class="col-xs-12">
                                        Nemáte žiadne budúce plány.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <div class="col-xs-12 col-sm-6 col-sm-pull-6 running-plans__div--old rp-list">
                            <h2>Minulé plány</h2>

                            @forelse($runningPlansOld as $runningPlan)
                                @include('running_plans.running_plan_box')
                            @empty
                                <div class="row rp-box">
                                    <div class="col-xs-12">
                                        Nemáte žiadne minulé plány.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection