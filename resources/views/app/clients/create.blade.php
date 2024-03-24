@extends('adminlte::page')

@section('title', 'Cadastro Cliente')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Cliente</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('clients.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Clientes</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('clients.store')}}" method="post">
        @csrf
        @include('app.clients._partials.form')
    </form>
@stop