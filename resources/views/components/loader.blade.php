<div wire:loading.delay wire:loading.class="overlay">
    <div class="overlay mt-5">
        <div class="spinner-grow text-primary" role="status">

        </div>
        <h5 class="p-3 text-muted">Aguarde carregando...</h5>
    </div>
</div>


@push('styles')
    <style>

        /*.card > .overlay {*/
        /*    position: absolute;*/
        /*    width: 100%;*/
        /*    height: 100%;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*}*/
        .overlay {
            border-radius: .25rem;
            -ms-flex-align: center;
            align-items: center;
            background-color: rgba(255, 255, 255, .7);
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: center;
            justify-content: center;
            z-index: 100;
        }


    </style>
@endpush