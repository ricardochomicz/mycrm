@extends('adminlte::page')

@section('title', 'Cadastro Usuário')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h4>Cadastro Usuário</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <form action="{{route('users.store')}}" method="post">
        @csrf
        @include('app.users._partials.form')
    </form>
@stop