@props([
'label'  => '',
'name' => '',
'id' => uniqid(),
'value' => '',
])
<div>
    @if($label!='')
        <label for="{{$id}}" class="form-label">{{$label}}</label>
    @endif
    <textarea  id="{{$id}}" name="{{$name}}" {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} autocomplete="off">{{$value}}</textarea>
    @error($name)
    <div class="invalid-feedback" style="display: block">{{ $message }}</div>
    @enderror
</div>
