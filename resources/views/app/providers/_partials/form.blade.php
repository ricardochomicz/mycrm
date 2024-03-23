

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-6">
                <x-input label="Nome Fornecedor" name="name" value="{{old('name') ?? @$provider->name}}"/>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('providers.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

