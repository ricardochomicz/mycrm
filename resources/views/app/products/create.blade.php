@props([
    'title' => 'Cadastro Produto',
    'breadcrumb' => 'Produtos',
    'route' => route('products.index'),
    'action' => route('products.store')
])
@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>{{$title}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{$route}}">Home</a></li>
                <li class="breadcrumb-item active">{{$breadcrumb}}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{$action}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('app.products._partials.form')
    </form>
@stop