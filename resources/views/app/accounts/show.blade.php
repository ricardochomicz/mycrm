@extends('adminlte::page')

@section('title', 'Detalhes Conta')

@section('content_header')
    <div class="d-flex bd-highlight">
        <div class="mr-auto p-1 bd-highlight"><h3>Detalhes Conta</h3></div>
        <div class="p-1 bd-highlight">
            <a href="{{route('accounts.create')}}" class="btn btn-dark">Nova Conta</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto">

            <div class="invoice p-3 mb-3">


                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">

                        <address>
                            <strong>Fornecedor: </strong>{{$account->provider->name}}<br>
                            <strong>Tipo Receita/Despesa: </strong>{{$account->revenueExpense->name}}<br>
                            <strong>Data lançamento: </strong>{{Carbon\Carbon::parse($account->created_at)->format('d/m/Y')}}<br>
                        </address>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Parcela</th>
                                <th class="text-center">Valor Principal</th>
                                <th class="text-center">Vencimento</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Pagamento</th>
                                <th class="text-center">Total Pago</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($account->parcels as $p)
                                <tr>
                                    <td>{{$p->number_parcel}}</td>
                                    <td class="text-center">R$ {{$p->value, 2}}</td>
                                    <td class="text-center">{{Carbon\Carbon::parse($p->due_date)->format('d/m/Y')}}</td>
                                    <td class="text-center">
                                        @if ($p->payment_status == 1)
                                            <span class="badge bg-success">Pago</span>
                                        @elseif ($p->due_date < Carbon\Carbon::now()->format("Y-m-d"))
                                            <span class="badge bg-danger">Vencido</span>
                                        @else
                                            <span class="badge bg-secondary">Aberto</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($p->payment)
                                            {{Carbon\Carbon::parse($p->payment)->format('d/m/Y')}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($p->payment_status == 1)
                                            @php
                                                $value = $account->parcels->where('payment_status', 1)->sum('value');
                                                $interest = $account->parcels->where('payment_status', 1)->sum('payment_interest');
                                                $total = $value + $interest;
                                            @endphp
                                            R$ {{number_format($total, 2, ',', '.')}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="row">


                    <div class="col-6">
                        <p class="lead">Saldo atualizado {{now()->format('d/m/Y')}}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th style="width:50%">Total:</th>
                                    <td>R$ {{$account->parcels->sum('value')}}</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Qtd Parcelas:</th>
                                    <td>{{$account->parcels->count('number_parcel')}}</td>
                                </tr>
                                <tr>
                                    <th>Juros/Multa:</th>
                                    <td>
                                        R$ {{number_format($account->parcels->sum('payment_interest'), 2, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <th>Valor pago:</th>
                                    <td>
                                        R$ {{number_format($account->parcels->where('payment_status', 1)->sum('value'), 2, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <th>Saldo devido:</th>
                                    <td>
                                        R$ {{number_format($account->parcels->where('payment_status', 0)->sum('value'), 2, ',', '.')}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{route('accounts.index')}}" class="btn btn-default"><i
                                    class="fas fa-chevron-circle-left"></i> Voltar</a>
                    </div>
                </div>
            </div>


        </div>
    </div>

@stop