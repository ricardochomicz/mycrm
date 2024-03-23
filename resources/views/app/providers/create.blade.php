@extends('adminlte::page')

@section('title', 'Cadastro Fornecedor')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Fornecedor</h4>
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
    <form action="{{route('providers.store')}}" method="post">
        @csrf
        @include('app.providers._partials.form')
    </form>
@stop