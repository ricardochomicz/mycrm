<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-6">
                <x-input label="Nome" name="name" value="{{old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-sm-6">
                <x-input label="E-mail" name="email" value="{{old('email') ?? @$data->email}}"/>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                <x-input label="Telefone" name="phone" class="phone" value="{{old('phone') ?? @$data->phone}}"/>
            </div>
            @if(Route::currentRouteNamed('users.create'))
                <div class="form-group col-sm-3">
                    <x-input label="Senha" name="password" value="{{old('password') ?? @$data->password}}"/>
                    <small>Caso o campo senha fique em branco, a senha de acesso será o <b>número do
                            telefone.</b></small>
                </div>
            @else
                <div class="form-group col-sm-6">
                    <label for="formFile" class="form-label">Escolha uma imagem:</label>
                    <input type="file" id="input-id-user" name="image" class="form-control">

                </div>
                <div class="form-group col-sm-1 text-center mt-4">
                    @if(@$data->image)
                        <img src="{{@$data->image_url}}" width="40px" alt="Imagem">
                    @endif
                </div>
            @endif
        </div>
        @can('isAdmin')
            <hr>
            <div class="row">
                <div class="form-group col-sm-6">
                    <x-select :options="$roles" label="Permissões" multiple data-actions-box="true" name="role_id[]"
                              :value="old('role_id', (isset($data)) ? $data->roles()->pluck('id')->toArray() : [])"/>
                </div>
            </div>
        @endcan
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('users.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

@pushonce('scripts')
    <script src="{{ asset('assets/plugins/inputmask/inputmask.js') }}"></script>
    <script src="{{asset('/assets/plugins/inputfile/js/inputfile.min.js')}}"></script>
    <script>
        $(function () {
            $('.phone').inputmask('99 99999-9999')
        })
        $(document).ready(function () {
            $("#input-id-user").fileinput({
                showUpload: false,
                dropZoneEnabled: false,
                maxFileCount: 10,
                inputGroupClass: "input-group"
            });
        });
    </script>
@endpushonce

