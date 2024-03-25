<div>
    <div class="card">

        <div class="card-body">

            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-sm-4 has-search">

                    <input wire:model.live="filters.search" class="form-control" name="search"
                           placeholder="pesquisa por nome...">
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <select name="trashed" data-live-search="true" title="Status" id="sel1"
                            wire:model.live="filters.trashed"
                            class="selectpicker">
                        <option value="only">Inativos</option>
                    </select>
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <x-select name="plan" title="Planos" data-live-search="true" id="sel2"
                              wire:model.live="filters.plan"
                              :options="$plans"/>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" wire:click="clearFilter">Limpar Filtros</button>
                </div>
            </div>

            <div class="small-box shadow-none">
                <x-loader wire:loading.delay wire:loading.class="overlay"></x-loader>

                <div class="table-responsive rounded">

                    <table class="table table-borderless table-hover">
                        <caption><small>Empresas cadastradas <b>{{$tenants->count()}}</b></small></caption>
                        <thead class="bg-gray-light">
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>CNPJ</th>
                            <th>Nome</th>
                            <th class="text-center">Plano Inscrito</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Atualizado em</th>
                            <th class="text-center" width="15%">...</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tenants as $tenant)
                            <tr>
                                <td class="align-middle">{{$tenant->id}}</td>
                                <td class="text-center align-middle">
                                    <img src="{{$tenant->logo_url}}" width="40px" alt="Imagem" class="rounded-circle">
                                </td>
                                <td class="align-middle">{{$tenant->document}}</td>
                                <td class="align-middle">{{$tenant->name}}</td>
                                <td class="align-middle text-center">{{$tenant->plan->name}}</td>
                                <td class="align-middle text-center"><span
                                            class="badge {{$tenant->active == 1 ? 'badge-success' : 'badge-danger'}}">{{$tenant->active == 1 ? 'Ativo' : 'Inativo'}}</span>
                                </td>
                                <td class="align-middle text-center">{{$tenant->updated_at}}</td>
                                <td class="align-middle text-center">

                                        <a href="{{route('tenants.edit', $tenant->id)}}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>

                                    @can('isSuperAdmin')
                                        @if($tenant->deleted_at != null)
                                            <a href="javascript:void(0)"
                                               onclick="ativaDesativa('{{route('tenants.destroy',  $tenant->id)}}', 'ativar', '{{$tenant->name}}')"
                                               class="btn btn-success btn-sm">
                                                <i class="fas fa-trash-restore"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)"
                                               onclick="ativaDesativa('{{route('tenants.destroy',  $tenant->id)}}', 'desativar', '{{$tenant->name}}')"
                                               class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{$tenants->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $("[name='my-checkbox']").bootstrapSwitch();
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('resetSelectpicker', (event) => {
                $("#sel1, #sel2").selectpicker('val', '') // Ou qualquer outra lógica de redefinição necessária
            });
        });

    </script>
@endpush

@push('styles')
    <style>
        .has-search .form-control {
            padding-left: 2.375rem;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }

    </style>
@endpush
