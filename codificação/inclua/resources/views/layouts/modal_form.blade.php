{{-- MODAL DE FORM --}}
<div class="modal fade" role="dialog" aria-hidden="true" id="{{ $id ?? "modal-form" }}" aria-labelledby="{{ $id ?? "modal-form" }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title-medium">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <form id="form-modal" class="flex-column" method="{{ $method ?? 'post' }}" action="{{ $route }}" enctype="multipart/form-data">
                    @if (!isset($method) || $method != 'get')
                        @csrf
                    @endif
                    {{ $slot }}
                    <input type="submit" id="send" style="display: none;">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secundary label-medium" type="button" data-dismiss="modal">
                    Fechar
                </button>
                <button id="submit-modal" class="btn btn-primary label-medium" type="button" onclick="this.closest('.modal.fade.show').querySelector('form').submit();">
                    {{ $textButton }}
                </button>
            </div>
        </div>
    </div>
</div>