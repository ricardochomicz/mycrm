
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="form-group col-md-6 col-sm-6 col-12">
                <x-input label="Nome" name="name" value="{{old('name') ?? @$data->name}}"/>
            </div>
            <div class="form-group col-md-2 col-sm-2 col-12">
                <label for="type">Tipo</label>
                <select name="type" id="type" class="selectpicker" title="Selecione" data-live-search="true">
                    @foreach($types as $type)
                        <option value="{{$type->id}}"
                                @if(@$data->type == $type->id) selected @endif>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{route('revenue-expenses.index')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

