<div>
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4" wire:ignore>
                <label for="supervisor_id">Supervisor</label>
                <select name="supervisor_id" wire:model="supervisor_id" id="supervisor_id" class="selectpicker"
                        title="Selecione um supervisor...">
                    @foreach($supervisor as $s)
                        <option value="{{$s->id}}" @if($s->id == $supervisor_id) selected @endif>{{$s->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4"></div>
            <div class="form-group col-sm-4 mt-2">
                <label for=""></label>
                <x-input type="search" class="form-control" wire:change="updateSearch" wire:model.live="search"
                         placeholder="Pesquisa usuário..."/>
            </div>
        </div>
        <hr>
        <div class="small-box shadow-none">
            <x-loader wire:loading.delay wire:loading.class="overlay"></x-loader>
            <table class="table table-borderless table-hover">
                <caption><small>Membros cadastrados na equipe <b>{{$membersCount}}</b></small></caption>
                <thead>
                <tr>
                    <th width="10%"></th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th class="text-center">Telefone</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $user)
                    <tr>
                        <td>
                            <label class="switch ">
                                <input type="checkbox" class="primary" name="user_id[]"
                                       wire:model="selectedUsers.{{ $user['id'] }}"
                                       value="1" {{ in_array($user['id'], array_keys($selectedUsers)) ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>{{$user['name']}}</td>
                        <td>{{$user['email']}}</td>
                        <td class="text-center">{{$user['phone']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <button type="button" wire:click="submit" class="btn btn-primary">Salvar</button>
        @if(Route::currentRouteNamed('teams.members.edit'))
            <a href="{{route('teams.index')}}" class="btn btn-secondary">Voltar</a>
        @endif
    </div>
</div>
