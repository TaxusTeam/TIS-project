@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Pouzivatelia na schvalenie</div>

				<div class="panel-body" >
					<?php $inactive = 0; ?>
					{!!  Form::open() !!}
					@forelse($names->all() as $name)
							@if ($name->is_active == 0 )
								<?php $inactive += 1; ?>
								{!! Form::label('name', 'Meno: '.$name->name) !!}
								{!!  Form::label('email', ' | E-mail: '.$name->email).' | ' !!}
								{!!  Form::label('checklabel', ' set as activated account: ',array('style' => 'font-weight:bold;')) !!}
								{!!  Form::radio('agree',$name->id) !!}
							@endif
						<br>
					@empty
						<p>We got nothing, database (table user) is empty!</p>
					@endforelse
					{!!  Form::submit('Activate', array('class' => 'pull-left btn btn-sm btn-primary')) !!}
					{!!  Form::close() !!}


				</div>
			</div>
			@if($inactive == 0)
				<p><strong>Vsetci cakatelia su schvaleny!</strong></p>
			@endif
		</div>
	</div>

</div>

@endsection



