@props([
    'titulo'        => 'Registro',
    'tipo'          => '',
    'msg_ativar'    => '',
    'msg_inativar'  => '',
    'msg_encerrar'  => '',
])
<div>
    <div class="modal fade" id="ativoInativoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">  <span id="labelTitulo">Ativar</span> {{ $titulo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding-bottom: 0px">
                    Você tem certeza que deseja <span class="labelCorpo">ativar</span>?
                    <br>
                    <p><b id="tituloRegistro"></b></p>
                    @if($msg_ativar != '')
                        <p id="msg_ativar"><i>{!! $msg_ativar !!}</i></p>
                    @endif
                    @if($msg_inativar != '')
                        <p id="msg_inativar"><i>{!! $msg_inativar !!}</i></p>
                    @endif
                    @if($msg_encerrar != '')
                        <p id="msg_encerrar"><i>{!! $msg_encerrar !!}</i></p>
                    @endif
                    @if($tipo != '')
                        <p class="text-danger" style="margin-bottom: 0px; text-align: right;">Essa ação só poderá ser desfeita após 48 horas.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <a id="btnAtivar" type="button" href="" class="btn btn-primary">Sim, <span
                                class="labelCorpo">ativar</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function ativaDesativa(rota, label, registro) {
            $('#msg_inativar').hide();
            $('#msg_ativar').hide();
            if(label == 'desativar' || label == 'deletar' ){
                $('#msg_inativar').show();
                $('#msg_ativar').hide();
                $('#msg_encerrar').hide();
            }
            if(label === 'ativar'){
                $('#msg_inativar').hide();
                $('#msg_ativar').show();
                $('#msg_encerrar').hide();
            }
            if(label === 'encerrar'){
                $('#msg_inativar').hide();
                $('#msg_ativar').hide();
                $('#msg_encerrar').show();
            }
            label = label.toLowerCase();
            $('#labelTitulo').html(label[0].toUpperCase() + label.substr(1));
            $('.labelCorpo').html(label);
            $('#tituloRegistro').html(registro);
            link = document.getElementById("btnAtivar");
            link.setAttribute('href', rota);
            $('#ativoInativoModal').modal('show');
        }
    </script>
@endpush
