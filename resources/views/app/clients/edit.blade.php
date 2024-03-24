@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Cliente</h4>
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
    <form action="{{route('clients.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.clients._partials.form')
    </form>
@stop