<div>
    <div class="card">

        <div class="card-body">

            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-sm-2">
                    <input wire:model="date_start" type="date" class="form-control" name="date_start">
                </div>
                <div class="form-group col-sm-2">
                    <input wire:model="date_end" type="date" class="form-control" name="date_end">
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <x-select :options="$revenues" title="Tipo Receita/Despesa" wire:model.live="revenue_expense"
                              id="sel2" multiple/>
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <select name="trashed" data-live-search="true" title="Status" id="sel1" wire:model.live="trashed"
                            class="selectpicker">
                        <option value="arrears">Em Atraso</option>
                        <option value="only">Inativos</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" wire:click="clearFilter">Limpar Filtros</button>
                </div>
            </div>

            <div class="small-box shadow-none">
                <x-loader wire:loading.delay wire:loading.class="overlay"></x-loader>

                <div class="table-responsive rounded">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-donate"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">A receber</span>
                                    <span class="info-box-number">R$ {{number_format($totalCommission, 2, ',', '.')}}<br><small>Saldo <b>R$ {{number_format($balance, 2, ',', '.')}}</b></small></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-cash-register"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total mês</span>
                                    <span class="info-box-number">R$ {{number_format($totalMonth, 2, ',', '.')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-calendar-times"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total em atraso</span>
                                    <span class="info-box-number">R$ {{number_format($totalArrears, 2, ',', '.')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-receipt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total pago</span>
                                    <span class="info-box-number">R$ {{number_format($totalPaid, 2, ',', '.')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-borderless table-hover">
                        <caption><small>Contas cadastradas <b>{{$data->count()}}</b></small></caption>
                        <thead class="bg-gray-light">
                        <tr>
                            <th>Parcela</th>
                            <th>Tipo Receita/Despesa</th>
                            <th class="text-center">Valor</th>
                            <th class="text-center">Vencimento</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Pagamento</th>
                            <th class="text-center">Total</th>
                            <th class="text-center" width="15%">...</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $d)
                            <tr @if($d->due_date < Carbon\Carbon::now()->format("Y-m-d") && $d->payment_status == 0) class="text-danger" @endif>
                                <td class="align-middle">{{$d->number_parcel}}</td>
                                <td class="align-middle">{{$d->account->revenueExpense->name}}<br>
                                    <small>{{$d->account->provider->name}}</small>
                                </td>
                                <td class="text-center align-middle">R$ {{moneyUStoBR($d->value)}}</td>
                                <td class="text-center align-middle">{{Carbon\Carbon::parse($d->due_date)->format('d/m/Y')}}</td>
                                <td class="text-center align-middle">
                                    @if ($d->payment_status == 1)
                                        <span class="badge bg-success">Pago</span>
                                    @elseif ($d->due_date < Carbon\Carbon::now()->format("Y-m-d"))
                                        <span class="badge bg-danger">Vencido</span><br>
                                        <small>
                                            Vencido
                                            à {{Carbon\Carbon::parse($d->due_date)->diffInDays(Carbon\Carbon::now())}}
                                            dia(s)
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">Aberto</span>
                                    @endif

                                </td>
                                <td class="text-center align-middle">
                                    @if($d->payment)
                                        {{Carbon\Carbon::parse($d->payment)->format('d/m/Y')}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    @if($d->payment_status == 1)
                                        R$ {{moneyUStoBR($d->amount_paid)}}
                                    @endif
                                </td>

                                <td class="text-center align-middle">

                                    @if($d->deleted_at === null)
                                        <a href="{{route('accounts.edit', $d->id)}}"
                                           class="btn btn-primary btn-sm tooltips" data-text="Editar">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <a href="{{route('accounts.detail', $d->account_id)}}"
                                           class="btn btn-secondary btn-sm tooltips" data-text="Detalhes Conta">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('accounts.destroy',  $d->id)}}', 'desativar', '{{$d->name}}')"
                                           class="btn btn-danger btn-sm tooltips" data-text="Desativar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('accounts.destroy',  $d->id)}}', 'ativar', '{{$d->name}}')"
                                           class="btn btn-secondary btn-sm tooltips" data-text="Ativar">
                                            <i class="fas fa-trash-restore"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{$data->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')

    <script>
        Livewire.on('resetSelectpicker', function () {
            $("#sel1, #sel2").selectpicker('val', '') // Ou qualquer outra lógica de redefinição necessária
        });
    </script>
@endpush