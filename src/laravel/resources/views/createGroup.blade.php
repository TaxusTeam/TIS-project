@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Vytvorenie skupiny</div>
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
						{!! Form::label('groupNameLabel', 'Meno skupiny: ',array('style' => 'font-weight:bold;')) !!}
						{!! Form::text('groupName') !!}<br><br>
						<p style="text-decoration: underline;"><strong>Bezci bez skupiny:</strong> </p>
						@forelse($names->all() as $name)
							@if ($name->group_id == 0 and $name->is_trainer == 0 and $name->is_admin != true and $name->is_active == 1)
								<?php $all += 1; ?>
								{!! Form::label('name', 'Meno: '.$name->name) !!}
								{!!  Form::label('email', ' | E-mail: '.$name->email).' | ' !!}
								{!!  Form::label('checklabel', ' choose in your Group: ',array('style' => 'font-weight:bold;')) !!}
								{!! Form::checkbox('agree[]', $name->id) !!}
							@endif
							<br>
						@empty
							<p>We got nothing, database (table user) is empty!</p>
						@endforelse
						<br>
						{!!  Form::submit('Create', array('class' => 'pull-left btn btn-sm btn-primary')) !!}
						{!!  Form::close() !!}
				</div>
			</div>
			@if($all == 0)
				<p><strong>Ziadny pouzivatelia na vyber do skupiny!</strong></p>
			@endif
		</div>
	</div>
</div>
@endsection
