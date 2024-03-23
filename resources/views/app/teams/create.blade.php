@extends('adminlte::page')

@section('title', 'Cadastro Equipe')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Equipe</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('teams.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Equipes</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('teams.store')}}" method="post">
        @csrf
        @include('app.teams._partials.form')
    </form>
@stop