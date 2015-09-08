@extends( 'layout' )

@section( 'pageTitle' )
    Create Echelon
@stop

@section( 'bodyclasses' )
@stop

@section( 'content' )
    <h1>Create Echelon</h1>

    @if( $errors->any() )
        <ul class="errors">
            @foreach( $errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@stop