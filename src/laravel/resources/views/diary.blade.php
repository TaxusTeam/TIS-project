@extends('app')

@section('content')

    


    <div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Zapisnik výsledkov behania</h1>
    		<p>Formulár pre zápis výsledkov behania do bežeckých plánov</p>
			<div class="panel panel-default">
				<div class="panel-heading">Zápisník</div>
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
					<?php $all = 0; ?>
						{!!  Form::open() !!}
						{!! Form::label('distanceLabel', 'Zabehnutá vzdialenosť: ') !!}
						{!! Form::text('distance') !!}
						{!! Form::label('distanceLabel2', 'km') !!}<br>
						{!! Form::label('dateLabel', 'Dátum behania: ') !!}
						{!! Form::date('date', \Carbon\Carbon::now()) !!}<br>
						{!! Form::label('moodLabel', 'Ako sa ti behalo? ') !!}
						{!! Form::select('mood', array(1 => 'Výborne', 2 => 'Dobre', 3 => 'Nič moc', 4 => 'Zle')) !!}<br>
						<br>
						{!!  Form::submit('Create', array('class' => 'pull-left btn btn-sm btn-primary')) !!}
						{!!  Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
</div>





@endsection