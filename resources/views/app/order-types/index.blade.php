@extends('adminlte::page')

@section('title', 'Tipo Pedido')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Tipo Pedido</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('order-types.create')}}" class="btn btn-dark">Novo Tipo Pedido</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:order-type.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Tipo Pedido" />
@stop

