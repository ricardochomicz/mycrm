@extends('adminlte::page')

@section('title', 'Cadastro Conta')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Conta</h4>
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
    <form action="{{route('accounts.store')}}" method="post">
        @csrf
        @include('app.accounts._partials.form')
    </form>
@stop