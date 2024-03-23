<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-3">
                <x-input label="CNPJ" name="document" value="{{old('document') ?? @$data->document}}" maxlength="14"/>
            </div>
            <div class="form-group col-sm-6">
                <x-input label="Nome Empresa" name="name" value="{{ old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-sm-3">
                <x-input label="Telefone" class="phone" name="phone" value="{{old('phone') ?? @$data->phone}}"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <x-input label="E-mail" name="email" value="{{old('email') ?? @$data->email}}"/>
            </div>

            <div class="form-group col-sm-6">
                <label for="formFile" class="form-label">Escolha uma imagem:</label>
                <input type="file" id="input-id" name="logo" class="form-control">
                <div class="form-group col-sm-1 text-center mt-3">
                    @if(@$data->logo)
                        <img src="{{@$data->logo_url}}" width="40px" alt="Imagem">
                    @endif
                </div>
            </div>


        </div>

        @can('isSuperAdmin')
            <hr>
            <div class="row">


                <div class="form-group col-sm-2">
                    <x-input type="date" label="Expira em" name="expires_at"
                             value="{{old('expires_at') ?? @$data->expires_at }}"/>
                </div>
                <div class="form-group col-sm-2">
                    <x-input label="ID Inscrição" name="subscription_id"
                             value="{{old('subscription_id') ?? @$data->subscription_id}}"/>
                </div>
                <div class="form-group col-sm-2">
                    <x-select label="Plano" data-live-search="true" :options="$plans" name="plan_id"
                              value="{{old('plan_id') ?? @$data->plan_id}}"/>
                </div>
                <div class="form-group ml-3 mt-2">
                    <label for="" class="ml-2">Ativo?</label>
                    <label class="switch">
                        <input type="checkbox" class="primary" name="active"
                               value="1" {{ isset($data) && $data->active == 1 ? 'checked' : 0 }} >
                        <span class="slider round"></span>
                    </label>
                    <br>
                    <label for="" class="ml-2">Plano Suspenso</label>
                    <label class="switch ">
                        <input type="checkbox" class="primary" name="subscription_suspended"
                               value="1" {{ isset($data) && $data->subscription_suspended == 1 ? 'checked' : 0 }} >
                        <span class="slider round"></span>
                    </label>

                </div>

            </div>
        @endcan
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('tenants.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<!-- data-inputmask="'mask': '99-9999999'" -->
@push('scripts')
    <script src="{{ asset('assets/plugins/inputmask/inputmask.js') }}"></script>
    <script src="{{asset('/assets/plugins/inputfile/js/inputfile.min.js')}}"></script>
    <script>
        $(function () {
            $('.phone').inputmask(['99 9999-9999','99 99999-9999'])
        })
        $(document).ready(function () {
            $("#input-id").fileinput({
                showUpload: true,
                dropZoneEnabled: false,
                maxFileCount: 10,
                inputGroupClass: "input-group"
            });
        });
    </script>
@endpush

