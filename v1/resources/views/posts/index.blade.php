@extends('layouts.index')
@section('title', $data['title'])



@section('article')
    <h1>{{ $data['title'] }}</h1>
    {!! $data['content'] !!}
@endsection
