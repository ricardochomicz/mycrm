@extends('adminlte::page')

@section('title', 'Editar Categoria')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Categoria</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Categorias</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('categories.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.categories._partials.form')
    </form>
@stop