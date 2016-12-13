@extends('app')

@section('content')

    <h1>Pre pouzivanie webu sa prosim prihlaste alebo registrujte.</h1>
    <br><h3>Database test</h3>
    @forelse($names->all() as $name)

        <section style="margin-left: 10%">
           <p>Meno: {{$name->name}}</p>
            <p>E-mail: {{$name->email}}</p>
          <p>passwd: {{$name->password}}</p>
        </section>
        <br>
    @empty
        <p>We got nothing, database (table user) is empty!</p>

    @endforelse


@endsection