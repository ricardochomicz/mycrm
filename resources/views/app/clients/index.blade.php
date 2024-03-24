@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Clientes</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('clients.create')}}" class="btn btn-dark">Novo Cliente</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:client.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Cliente" />
@stop

