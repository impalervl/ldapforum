@extends('layouts.front')

@section('heading')

    @can('create', App\Thread::class)
    <a class="btn btn-primary pull-right"  href="{{route('thread.create')}}">Create Thread</a> <br>
    @endcan

@endsection

@section('content')

@include('thread.partials.thread-list')

@endsection