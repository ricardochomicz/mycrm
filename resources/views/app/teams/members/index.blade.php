@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Membros Equipe</h3></div>
    </div>
@stop

@section('content')
    @include('app.teams.members.form')
@stop