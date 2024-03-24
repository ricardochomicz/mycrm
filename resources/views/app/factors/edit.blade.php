@extends('adminlte::page')

@section('title', 'Editar Fator Comissão')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Fator Comissão</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('factors.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Fator Comissão</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('factors.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.factors._partials.form')
    </form>
@stop