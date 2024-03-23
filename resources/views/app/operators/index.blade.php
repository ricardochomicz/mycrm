@extends('adminlte::page')

@section('title', 'Operadora')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Operadoras</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('operators.create')}}" class="btn btn-dark">Nova Operadora</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:operator.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Operadora" />
@stop

