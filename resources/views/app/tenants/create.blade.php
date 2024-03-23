@extends('adminlte::page')

@section('title', 'Cadastro Empresa')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Empresa</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('tenants.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Empresas</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('tenants.store')}}" method="post">
        @csrf
        @include('app.tenants._partials.form')
    </form>
@stop