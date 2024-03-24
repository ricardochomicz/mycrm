@extends('adminlte::page')

@section('title', 'Cadastro Classificação')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Classificação</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('classifications.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Classificação</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('classifications.store')}}" method="post">
        @csrf
        @include('app.classifications._partials.form')
    </form>
@stop