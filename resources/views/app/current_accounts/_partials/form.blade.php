

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-6">
                <x-select :options="$tenants" title="Selecione uma empresa..." name="tenant_id" data-live-search="true" value="{{old('tenant_id') ?? @$account->tenant_id}}"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <x-input label="Nome Banco" name="name" value="{{old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-sm-2">
                <x-input label="Agência" name="agency" value="{{old('agency') ?? @$data->agency}}"/>
            </div>
            <div class="form-group col-sm-3">
                <x-input label="Conta" name="account" value="{{old('account') ?? @$data->account}}"/>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('current.accounts.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

