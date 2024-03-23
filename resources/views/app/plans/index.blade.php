@extends('adminlte::page')

@section('title', 'Categoria')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Planos</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('plans.create')}}" class="btn btn-dark">Novo Plano</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:plan.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Plano" />
@stop

