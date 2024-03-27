@extends('adminlte::page')

@section('title', 'Tipo Receita/Despesa')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Receitas e Despesas</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('revenue-expenses.create')}}" class="btn btn-dark">Novo Tipo</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:revenue-expense.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Tipo Receita/Despesa" />
@stop

