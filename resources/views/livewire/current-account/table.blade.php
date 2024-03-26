<div>
    <div class="card">

        <div class="card-body">

            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-sm-6 has-search">
                    <input wire:model.live="search" class="form-control" name="search"
                           placeholder="pesquisa por nome...">
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <select name="trashed" data-live-search="true" title="Status" id="sel1" wire:model.live="trashed"
                            class="selectpicker">
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

                    <table class="table table-borderless table-hover">
                        <caption><small>Contas cadastradas <b>{{$data->count()}}</b></small></caption>
                        <thead class="bg-gray-light">
                        <tr>
                            <th>#</th>
                            <th>Empresa</th>
                            <th>Banco</th>
                            <th class="text-center">Agência/Conta</th>
                            <th>Criado em</th>
                            <th class="text-center" width="15%">...</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $currentAccount)
                            <tr>
                                <td>{{$currentAccount->id}}</td>
                                <td>{{$currentAccount->tenant->name}}</td>
                                <td>{{$currentAccount->name}}</td>
                                <td class="text-center">{{$currentAccount->agency}} / {{$currentAccount->account}}</td>
                                <td>{{$currentAccount->created_at}}</td>
                                <td class="text-center">

                                    @if($currentAccount->deleted_at === null)
                                        <a href="{{route('current.accounts.edit', $currentAccount->id)}}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('current.accounts.destroy',  $currentAccount->id)}}', 'desativar', '{{$currentAccount->name}}')"
                                           class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('current.accounts.destroy',  $currentAccount->id)}}', 'ativar', '{{$currentAccount->name}}')"
                                           class="btn btn-secondary btn-sm">
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
            $("#sel1").selectpicker('val', '') // Ou qualquer outra lógica de redefinição necessária
        });
    </script>
@endpush