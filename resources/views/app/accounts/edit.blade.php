@extends('adminlte::page')

@section('title', 'Editar Conta')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Editar Conta</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('accounts.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Contas a Pagar e Receber</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('accounts.update', $data->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('app.accounts._partials.form')
    </form>
@stop