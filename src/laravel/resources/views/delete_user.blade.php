@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Vymazanie pouzivatela: </div>

				<div class="panel-body" >
					<?php $users = 0; ?>
					{!!  Form::open() !!}
					@forelse($names->all() as $name)
							@if ($name->is_admin == '0' )
								<?php $users += 1; ?>
								{!! Form::label('name', 'Meno: '.$name->name) !!}
								{!!  Form::label('email', ' | E-mail: '.$name->email).' | ' !!}
								{!!  Form::label('checklabel', ' set as activated account: ',array('style' => 'font-weight:bold;')) !!}
								{!!  Form::radio('agree',$name->id) !!}
							@endif
						<br>
					@empty
						<p>We got nothing, database (table user) is empty!</p>
					@endforelse
					{!!  Form::submit('Delete', array('class' => 'pull-left btn btn-sm btn-primary')) !!}
					{!!  Form::close() !!}


				</div>
			</div>
			@if($users == 0)
				<p><strong>Vsetci pouzivatelia su vymazany!</strong></p>
			@endif
		</div>
	</div>
</div>

@endsection



