@extends('adminlte::page')

@section('title', 'Fator Comissão')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Fator Comissão</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('factors.create')}}" class="btn btn-dark">Novo Fator</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:factor.table />

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Fator" />
@stop

