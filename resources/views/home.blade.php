@extends('layouts.site')

@section('content')
    @foreach($sections as $section)
        @includeIf('home.sections.'.$section->key, ['section' => $section])
    @endforeach
@endsection
