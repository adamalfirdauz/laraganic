@extends('templates.index')

@section('header')
        <h1>
            {{$head->title}}
            <small>{{$head->subtitle}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{$head->title}}</a></li>
            <li class="active">{{$head->subtitle}}</li>
        </ol>
@endsection

@section('content')
    
@endsection