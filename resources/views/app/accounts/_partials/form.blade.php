<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <x-select :options="$providers" name="provider_id" label="Fornecedor" title="Selecione..."
                          value="{{old('provider_id') ?? @$data->account->provider_id}}" data-size="5"/>
            </div>
            <div class="form-group col-sm-4">
                <x-select :options="$revenues" name="revenue_expense_id" label="Tipo Receita/Despesa"
                          title="Selecione..." data-size="5"
                          value="{{old('revenue_expense_id') ?? @$data->account->revenue_expense_id}}"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2">
                <x-input name="qty" type="number" label="Qtd Parcelas" value="1" class="text-center"
                         :disabled="$disableQtyInput"/>
            </div>
            <div class="form-group col-sm-2">
                <x-input name="value" label="Valor Parcela" id="value" value="{{old('value') ?? @moneyUStoBR($data->value)}}" oninput="formatCurrency(this)"/>
            </div>
            <div class="form-group col-sm-2">
                <x-input name="due_date" type="date" label="Vencimento" value="{{old('due_date') ?? @$data->due_date}}"
                         class="text-center"/>
            </div>
            @if(Route::currentRouteNamed('accounts.create'))
                <div class="form-group col-sm-3 mt-3">
                    <small>Caso seja mais de uma parcela, informar o valor da parcela e primeiro vencimento.</small>
                </div>
            @endif
        </div>
        @if(Route::currentRouteNamed('accounts.edit'))
            <div class="row">
                <div class="form-group col-sm-2">
                    <x-input name="amount_paid" label="Valor Pago" id="amount_paid"
                             value="{{old('amount_paid') ?? @moneyUStoBR(@$data->amount_paid)}}" oninput="formatCurrency(this)"/>
                </div>
                <div class="form-group col-sm-2">
                    <x-input name="payment_interest" label="Juros/Mora" id="payment_interest"
                             value="{{old('payment_interest') ?? moneyUStoBR(@$data->payment_interest)}}" />
                </div>
                <div class="form-group col-sm-2">
                    <x-input name="payment" type="date" label="Data Pagamento"
                             value="{{old('payment') ?? @$data->payment}}" class="text-center"/>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="form-group col-sm-12">
                <label for="description">Observações:</label>
                <textarea id="description" class="form-control" name="description">
                    {{old('description') ?? @$data->account->description}}
                </textarea>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('accounts.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

@pushonce('scripts')
    <script src="{{ asset('assets/plugins/inputmask/inputmask.js') }}"></script>
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
        let campo = document.querySelector('textarea');
        campo.value = campo.value.trim();

        const valueInput = document.getElementById('value')
        const amount_paid = document.getElementById('amount_paid')
        const payment_interest = document.getElementById('payment_interest')

        amount_paid.addEventListener('input', calculatePaymentInterest)

        function calculatePaymentInterest() {
            const value = parseFloat(valueInput.value.replace(',', '.'));

            const amountPaid = parseFloat(amount_paid.value.replace(',', '.'));
            console.log(amountPaid)
            if (!isNaN(value) && !isNaN(amountPaid)) {
                const paymentInterest = amountPaid - value;
                payment_interest.value = paymentInterest.toLocaleString('pt-BR', {minimumFractionDigits: 2});
                // payment_interest.value = paymentInterest.toFixed(2);

            } else {
                payment_interest.value = ''; // Se um dos valores for inválido, limpa o campo de pagamento de juros
            }
        }

    </script>
@endpushonce


