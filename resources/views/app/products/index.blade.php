@extends('adminlte::page')

@section('title', 'Produto')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Produtos</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('products.create')}}" class="btn btn-dark">Novo Produto</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:product.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Produto" />
@stop

