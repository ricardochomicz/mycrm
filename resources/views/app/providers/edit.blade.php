@extends('adminlte::page')

@section('title', 'Editar Fornecedor')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Fornecedor</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('providers.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Fornecedor</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('providers.update', $provider->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.providers._partials.form')
    </form>
@stop