@extends('adminlte::page')

@section('title', 'Contas a Pagar e Receber')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Contas a Pagar e Receber</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('accounts.create')}}" class="btn btn-dark">Nova Conta</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:account.table />


        </div>
    </div>
    <x-modal_ativo_inativo titulo="Conta" />
@stop

