@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Editovanie skupiny: </div>

				<div class="panel-body" >

					{!!  Form::open() !!}
					{!! Form::text('id', $grp->id,array('style' => 'display:none;')) !!}<br>
					{!! Form::label('name', 'Meno skupiny: ') !!}
						{!! Form::text('grp_name', $grp->name) !!} <br><br>

					{!! Form::label('delete', 'Vymaz bezcov zo skupiny: ',array('style' => 'font-weight:bold;')) !!}<br><br>

						@foreach($names as $name)
							@if($name->group_id == $grp->id)
								{!! Form::label('name', 'Meno: '.$name->name ) !!}
								{!! Form::label('email', ' | E-mail: '.$name->email).' | ' !!}
								{!! Form::label('checklabel', ' delete Runner: ',array('style' => 'font-weight:bold;')) !!}
								{!! Form::checkbox('agreeDel[]', $name->id) !!} <br>
							@endif
						@endforeach
					<br>
					{!! Form::label('add', 'Pridaj bezcov bez skupiny: ',array('style' => 'font-weight:bold;')) !!}<br><br>

					@forelse($names as $name)
						@if($name->group_id == 0 and $name->is_trainer == 0 and $name->is_admin != true and $name->is_active == 1)
							{!! Form::label('name', 'Meno: '.$name->name ) !!}
							{!! Form::label('email', ' | E-mail: '.$name->email).' | ' !!}
							{!! Form::label('checklabel', ' add Runner: ',array('style' => 'font-weight:bold;')) !!}
							{!! Form::checkbox('agreeAdd[]', $name->id) !!} <br>
						@endif
					@empty
						<p>We got nothing, all runners have a group!</p>
					@endforelse



					
					{!!  Form::submit('Save', array('class' => 'pull-left btn btn-sm btn-primary','name'=>'action','value'=>'editing')) !!}
					{!!  Form::close() !!}


				</div>
			</div>

		</div>
	</div>
</div>

@endsection



