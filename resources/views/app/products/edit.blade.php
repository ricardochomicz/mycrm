@extends('adminlte::page')

@section('title', 'Editar Produto')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Produto</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('products.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Produtos</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('products.update', $data->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('app.products._partials.form')
    </form>
@stop