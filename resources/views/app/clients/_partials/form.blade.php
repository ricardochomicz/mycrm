<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-3">
                <x-input label="CNPJ" onkeyup="getClient(this.value)" name="document"
                         value="{{old('document') ?? @$data->document}}" maxlength="14" placeholder="somente números"/>
            </div>
            <div class="form-group col-sm-7">
                <x-input label="Razão Social" name="name" value="{{old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-sm-2">
                <x-input label="Telefone" name="phone" id="phone" class="mask"
                         value="{{old('phone') ?? @$data->phone}}"/>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                <x-input name="address" label="Endereço" value="{{old('address') ?? @$data->address}}"/>
            </div>
            <div class="form-group col-sm-1">
                <x-input name="number" label="Número" value="{{old('number') ?? @$data->number}}"/>
            </div>
            <div class="form-group col-sm-3">
                <x-input name="village" label="Bairro" value="{{old('village') ?? @$data->village}}"/>
            </div>
            <div class="form-group col-sm-3">
                <x-input name="city" label="Cidade" value="{{old('city') ?? @$data->city}}"/>
            </div>
            <div class="form-group col-sm-1">
                <x-input name="state" label="UF" value="{{old('state') ?? @$data->state}}"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2">
                <x-input name="zip_code" label="CEP" value="{{old('zip_code') ?? @$data->zip_code}}"/>
            </div>
            <div class="form-group col-sm-2">
                <x-input name="cnae" label="CNAE" value="{{old('cnae') ?? @$data->cnae}}"/>
            </div>
            <div class="form-group col-sm-8">
                <x-input name="cnae_text" label="CNAE Descrição" value="{{old('cnae_text') ?? @$data->cnae_text}}"/>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-3">
                <x-select :options="$operators" name="operator_id" title="Selecione a operadora..." data-live-search="true"
                          label="Operadora" value="{{old('operator_id') ?? @$data->operator_id}}"/>
            </div>
        </div>
        @if(Route::currentRouteNamed('clients.edit'))
            <div class="row">
                <div class="form-group col-sm-3">
                    <x-select :options="$classifications" name="classification_id" title="Selecione a classificação..." data-live-search="true"
                              label="Classificação" value="{{old('classification_id') ?? @$data->classification_id}}"/>
                </div>
                <div class="form-group col-sm-3">
                    <x-input name="number_client" label="Número Cliente"
                             value="{{old('number_client') ?? @$data->number_client}}"/>
                </div>
                <div class="form-group col-sm-3">
                    <x-input name="password_client" label="Senha Cliente"
                             value="{{old('password_client') ?? @$data->password_client}}"/>
                </div>
                <div class="form-group col-sm-3">
                    <x-select :options="$users" title="Selecione o consultor..." name="user_id" data-live-search="true"
                              label="Consultor" value="{{old('user_id') ?? @$data->user_id}}"/>
                </div>
            </div>
        @endif


    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('clients.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/plugins/inputmask/inputmask.js') }}"></script>

    <script>
        $(function () {
            $('.mask').inputmask('99 99999-9999')
        })

        function getClient(doc) {
            let baseUrl = '';

            if ("{{ app()->environment() }}" === 'local') {
                baseUrl = 'http://localhost:8082';
            } else {
                baseUrl = 'https://42telecom.com.br/mycrm';
            }

            let url = baseUrl + '/app/clients/' + doc + '/document';

            if (doc.length === 14) {
                $.ajax({
                    url: url,
                    method: "GET",
                    success: function (data) {
                        console.log(data)
                        if (data) {
                            Swal.fire({
                                title: 'Ops!',
                                text: 'CNPJ informado já possui cadastro.',
                                icon: 'error',
                                toast: true,
                                confirmButtonText: '<a href="{{route('clients.index')}}" style="color: #fff">Fechar</a>',
                            })
                            console.log("Cliente já cadastrado.");
                        } else {
                            cnpj = doc.replace(/[^\d]+/g, "");
                            $.ajax({
                                url: 'https://receitaws.com.br/v1/cnpj/' + cnpj,
                                method: "GET",
                                dataType: "jsonp",
                                complete: function (xhr) {
                                    $("#phone").focus();
                                    let result = xhr.responseJSON;
                                    $("input[name=name]").val(result.nome);
                                    $("input[name=zip_code]").val(result.cep);
                                    $("input[name=address]").val(result.logradouro);
                                    $("input[name=number]").val(result.numero);
                                    $("input[name=village]").val(result.bairro);
                                    $("input[name=state]").val(result.uf);
                                    $("input[name=city]").val(result.municipio);
                                    $("input[name=cnae]").val(result.atividade_principal[0].code);
                                    $("input[name=cnae_text]").val(result.atividade_principal[0].text);
                                }
                            });
                        }
                    }
                })


            }
        }
    </script>
@endpushonce
