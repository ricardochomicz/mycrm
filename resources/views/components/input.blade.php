@props([
    'label'  => '',
    'type' => 'text',
    'name' => '',
    'id' => uniqid(),
    'readonly' => false,
    'date_time' => false,
    'style' => '',
    'inputGroup' => '',
])
<div>
    @if($label!='')
        <label for="{{$id}}" class="form-label">{{$label}}</label>
    @endif
    @if($inputGroup != '')
        <div {{ $attributes->class(['input-group', 'is-invalid' => $errors->has($name)]) }}>
            @endif
            <input type="{{$type}}" id="{{$id}}" name="{{$name}}" {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }} @if($readonly) readonly @endif autocomplete="off" @if($style!='') style="{{$style}}" @endif
            >
            @if($inputGroup != '')
                <span class="input-group-text" id="basic-addon2">{{$inputGroup}}</span>
        </div>
    @endif
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>