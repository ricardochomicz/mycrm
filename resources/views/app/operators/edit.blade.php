@extends('adminlte::page')

@section('title', 'Editar Operadora')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Operadora</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('operators.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Operadoras</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('operators.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.operators._partials.form')
    </form>
@stop