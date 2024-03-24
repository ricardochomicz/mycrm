<div>
    <div class="card">
        <div class="card-body">

            <h6><i class="fas fa-filter"></i> Filtros</h6>
            <div class="row">
                <div class="form-group col-sm-6 has-search">
                    <input wire:model.live="filters.search" class="form-control" name="search"
                           placeholder="pesquisa por nome...">
                </div>
                <div class="form-group col-sm-3" wire:ignore>
                    <select name="trashed" data-live-search="true" title="Status" id="sel1" wire:model.live="filters.trashed"
                            class="selectpicker">
                        <option value="only">Inativos</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" wire:click="clearFilter">Limpar Filtros</button>
                </div>
            </div>

            <x-loader wire:loading.delay wire:loading.class="overlay"></x-loader>

            <div class="table-responsive rounded">

                <table class="table table-borderless table-hover">
                    <caption><small>Clientes cadastrados <b>{{$data->count()}}</b></small></caption>
                    <thead class="bg-gray-light">
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th class="text-center">Operadora</th>
                        <th>Cidade</th>
                        <th>Criado em</th>
                        <th class="text-center" width="15%">...</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $d)
                        <tr>
                            <td>{{$d->id}}</td>
                            <td>{{$d->name}}
                                <br><small id="document" class="tooltips" style="cursor: pointer" data-text="Copiar" onclick="copy({{$d->document}}, $event)">{{$d->document}}</small>
                            </td>
                            <td class="text-center">{{$d->operator?->name}}</td>
                            <td>{{$d->city}}</td>
                            <td>{{$d->created_at}}</td>
                            <td class="text-center">

                                @if($d->deleted_at === null)
                                    <a href="{{route('clients.edit', $d->id)}}"
                                       class="btn btn-primary btn-sm tooltips" data-text="Editar">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                    <a href="{{route('clients.show', $d->uuid)}}"
                                       class="btn btn-secondary btn-sm tooltips" data-text="Detalhes">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                       onclick="ativaDesativa('{{route('clients.destroy',  $d->id)}}', 'desativar', '{{$d->name}}')"
                                       class="btn btn-danger btn-sm tooltips" data-text="Desativar">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0)"
                                       onclick="ativaDesativa('{{route('clients.destroy',  $d->id)}}', 'ativar', '{{$d->name}}')"
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

@push('scripts')
    <script>
        Livewire.on('resetSelectpicker', function () {
            $("#sel1").selectpicker('val', '') // Ou qualquer outra lógica de redefinição necessária
        });

        function copy(doc, event){
            const input = document.createElement("input");
            input.value = doc;
            document.body.appendChild(input);
            input.select(); // Seleciona o texto dentro do input
            document.execCommand("copy"); // Copia o texto selecionado
            document.body.removeChild(input); // Remove o elemento input
            const target = event.target;
            target.setAttribute("data-text", "Copiado!"); // Altera o texto do tooltip
        }
    </script>
@endpush
