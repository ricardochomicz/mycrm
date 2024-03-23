@extends('adminlte::page')

@section('title', 'Conta Corrente')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Conta Corrente</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('current.accounts.create')}}" class="btn btn-dark">Nova Conta Corrente</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:current-account.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Contas" />
@stop

