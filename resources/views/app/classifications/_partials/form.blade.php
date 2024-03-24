
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <x-input label="Nome" name="name" value="{{old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-sm-4">
                <x-input label="Meses" name="months" value="{{old('months') ?? @$data->months}}"/>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('classifications.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

