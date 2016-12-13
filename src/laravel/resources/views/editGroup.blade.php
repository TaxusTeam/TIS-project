@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Vyber skupiny na editovanie: </div>

				<div class="panel-body" >

					{!!  Form::open() !!}
						{!! Form::label('name', 'Vyber skupinu: ') !!}
						{!!  Form::select('group',$items) !!} <br>

					{!!  Form::submit('Edit', array('class' => 'pull-left btn btn-sm btn-primary','name'=>'action','value'=>'load')) !!}
					{!!  Form::close() !!}


				</div>
			</div>

		</div>
	</div>
</div>

@endsection



