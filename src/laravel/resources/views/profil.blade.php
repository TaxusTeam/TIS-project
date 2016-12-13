@extends('app')

@section('content')

	<!-- Vytiahnutie udajov z db o pouzivatelovi-->
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Profil</div>

				<div class="panel-body">

					@if (Auth::check())


					@forelse($names->all() as $name)
							@if($name->id == $userID)
								<section style="margin-left: 5%">
									<img src="uploads/avatars/{{$name->avatar}}" style="width: 150px;height: 150px;border-radius:50%; float: left;margin-right: 25px;">
									<p>Meno: {{$name->name}}</p>
									<p>E-mail: {{$name->email}}</p>
								</section>
								<br>
							@endif
						@empty
							<p>We got nothing, database (table user) is empty!</p>

						@endforelse
					@endif

						<form enctype="multipart/form-data" action="profil" method="POST" style="float: left;">
							<label style="color: purple;">Zmenit obrazok profilu</label>
							<input type="file" name="avatar">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<br>
							<input type="submit" class="pull-left btn btn-sm btn-primary">
						</form>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
