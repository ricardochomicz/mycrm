@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Empresas</h3></div>
        @can('isSuperAdmin')
            <div class="p-1 bd-highlight">
                <a href="{{route('tenants.create')}}" class="btn btn-dark">Nova Empresa</a>
            </div>
        @endcan
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <livewire:tenants.table/>

        </div>
    </div>
    <x-modal_ativo_inativo titulo="Empresa"/>
@stop