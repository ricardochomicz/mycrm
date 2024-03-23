@extends('adminlte::page')

@section('title', 'Equipe')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Equipes</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('teams.create')}}" class="btn btn-dark">Nova Equipe</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:team.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Equipe" />
@stop

