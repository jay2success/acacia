@extends('permissions::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from acacia: {!! config('permissions.name') !!}
    </p>
@endsection
