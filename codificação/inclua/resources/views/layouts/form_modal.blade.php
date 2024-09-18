{{-- MODAL DE FORM --}}
<div class="modal fade" role="dialog" aria-hidden="true" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label class="title-medium">{{ $title }}</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form class="flex-column" method="post" action="{{ $route }}" enctype="multipart/form-data">
                    @csrf
                    {{ $slot }}
                    <input type="submit" id="send" style="display: none;">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secundary label-medium" type="button" data-dismiss="modal">
                    Fechar
                </button>
                <button class="btn btn-primary label-medium" type="button" onclick="$('#send').click();">
                    Salvar <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>