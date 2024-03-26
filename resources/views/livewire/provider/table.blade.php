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
                    <select name="trashed" data-live-search="true" id="sel1" wire:model.live="trashed"
                            class="selectpicker" title="Status">
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
                        <caption><small>Fornecedores cadastrados <b>{{$providers->count()}}</b></small></caption>
                        <thead class="bg-gray-light">
                        <tr>
                            <th>#</th>
                            <th>Fornecedor</th>
                            <th>Criado em</th>
                            <th class="text-center" width="15%">...</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($providers as $provider)
                            <tr>
                                <td>{{$provider->id}}</td>
                                <td>{{$provider->name}}</td>
                                <td>{{$provider->created_at}}</td>
                                <td class="text-center">

                                    @if($provider->deleted_at === null)
                                        <a href="{{route('providers.edit', $provider->id)}}"
                                           class="btn btn-primary btn-sm" @popper(Editar)>
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('providers.destroy',  $provider->id)}}', 'desativar', '{{$provider->name}}')"
                                           class="btn btn-danger btn-sm" @popper(Desativar)>
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)"
                                           onclick="ativaDesativa('{{route('providers.destroy',  $provider->id)}}', 'ativar', '{{$provider->name}}')"
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
                        {{$providers->links()}}
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

