@extends('adminlte::page')

@section('title', 'Usuário')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Usuários</h3></div>
        @can('isAdmin')
            <div class="p-1 bd-highlight">
                <a href="{{route('users.create')}}" class="btn btn-dark">Novo Usuário</a>
            </div>
        @endcan
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:user.table/>

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Usuário"/>
@stop

