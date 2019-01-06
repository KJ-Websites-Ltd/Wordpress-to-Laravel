@extends('layouts.index')
@section('title', $data['title'])
@section('article')
    {!! $data['content'] !!}
@endsection


