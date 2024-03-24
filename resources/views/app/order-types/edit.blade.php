@extends('adminlte::page')

@section('title', 'Editar Tipo Pedido')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Tipo Pedido</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('order-types.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Tipo Pedido</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('order-types.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.order-types._partials.form')
    </form>
@stop