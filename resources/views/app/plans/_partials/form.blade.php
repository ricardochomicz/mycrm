<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <x-input label="Nome" name="name" value="{{old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-sm-4">
                <x-input label="Valor" name="price" oninput="formatCurrency(this)" value="{{old('price') ?? @$data->price}}"/>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                <x-input label="Descrição" name="description" value="{{old('description') ?? @$data->description}}"/>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('plans.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

@pushonce('scripts')
    <script>
        function formatCurrency(input) {
            let valor = input.value;
            valor = valor.replace(/\D/g, '');
            valor = (parseInt(valor) / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            if (valor === 'NaN') {
                input.value = '';
            } else {
                input.value = valor;
            }
        }
    </script>
@endpushonce

