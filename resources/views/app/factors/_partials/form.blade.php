
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-3">
                <x-input label="Fator %" name="factor" value="{{old('factor') ?? @$data->factor}}" placeholder="Ex. 4.50"/>
            </div>
            <div class="form-group col-sm-3">
                <x-select :options="$operators" title="Selecione..." label="Operadora" name="operator_id" value="{{old('operator_id') ?? @$data->operator_id}}"/>
            </div>
            <div class="form-group col-sm-3">
                <x-select :options="$types" title="Selecione..." label="Tipo Pedido" name="ordertype_id" value="{{old('ordertype_id') ?? @$data->ordertype_id}}"/>
            </div>

        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('factors.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

