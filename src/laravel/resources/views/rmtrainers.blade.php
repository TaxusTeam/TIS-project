@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Odstranenie Trenera</div>

				<div class="panel-body">
					{!!  Form::open() !!}
					@forelse($names->all() as $name)
							@if (($name->is_admin == '0'or $name->is_admin == false) and ($name->is_trainer!='0' or $name->is_trainer == true ))
								{!! Form::label('name', 'Meno: '.$name->name) !!}
								{!!  Form::label('email', ' | E-mail: '.$name->email.' | ') !!}
								{!!  Form::label('checklabel', ' remove from trainers: ',array('style' => 'font-weight:bold;')) !!}
								{!!  Form::radio('disagree',$name->email) !!}
							@endif
						<br>
					@empty
						<p>We got nothing, database (table user) is empty!</p>
					@endforelse
					{!!  Form::submit('Remove', array('class' => 'pull-left btn btn-sm btn-primary')) !!}
					{!!  Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@endsection



