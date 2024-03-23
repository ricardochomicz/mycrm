@extends('adminlte::page')

@section('title', 'Cadastro Conta Corrente')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Conta Corrente</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('current.accounts.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Conta Corrente</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('current.accounts.store')}}" method="post">
        @csrf
        @include('app.current_accounts._partials.form')
    </form>
@stop