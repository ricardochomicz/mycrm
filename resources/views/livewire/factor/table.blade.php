<div>
    <div class="card">

        <div class="card-body">

            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">

                <div class="form-group col-sm-3" wire:ignore>
                    <select name="trashed" data-live-search="true" title="Status" id="sel1" wire:model.live="trashed"
                            class="selectpicker">
                        <option value="only">Inativos</option>
                    </select>
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <x-select :options="$operators" title="Operadora" id="sel2" wire:model.live="operator"/>
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <x-select :options="$types" title="Tipo Pedido" id="sel3" wire:model.live="type"/>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" wire:click="clearFilter">Limpar Filtros</button>
                </div>
            </div>

            <div class="small-box shadow-none">
                <x-loader wire:loading.delay wire:loading.class="overlay"></x-loader>

                <div class="table-responsive rounded">

                    <table class="table table-borderless table-hover">
                        <caption><small>Fator Comissão cadastrados <b>{{$data->count()}}</b></small></caption>
                        <thead class="bg-gray-light">
                        <tr>
                            <th>#</th>
                            <th class="text-center">Fator</th>
                            <th class="text-center">Operadora</th>
                            <th class="text-center">Tipo Pedido</th>
                            <th>Criado em</th>
                            <th class="text-center" width="15%">...</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td class="text-center">{{$d->factor}} %</td>
                                <td class="text-center">{{$d->operator->name}}</td>
                                <td class="text-center">{{$d->ordertype->name}}</td>
                                <td>{{$d->created_at}}</td>
                                <td class="text-center">

                                    @if($d->deleted_at === null)
                                        <a href="{{route('factors.edit', $d->id)}}"
                                           class="btn btn-primary btn-sm tooltips" data-text="Editar">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('factors.destroy',  $d->id)}}', 'desativar', '{{$d->name}}')"
                                           class="btn btn-danger btn-sm tooltips" data-text="Desativar">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('factors.destroy',  $d->id)}}', 'ativar', '{{$d->name}}')"
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
            $("#sel1, #sel2, #sel3").selectpicker('val', '') // Ou qualquer outra lógica de redefinição necessária
        });
    </script>
@endpush