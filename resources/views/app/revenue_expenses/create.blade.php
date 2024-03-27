@extends('adminlte::page')

@section('title', 'Cadastro Tipo Receita/Despesa')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Tipo Receita/Despesa</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('revenue-expenses.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Receitas e Despesas</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('revenue-expenses.store')}}" method="post">
        @csrf
        @include('app.revenue_expenses._partials.form')
    </form>
@stop