<div id='{{ $id }}' class='modal' tabindex='-1'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header modal-header-danger bg-danger'>
                <h4 class='modal-title text-white'>{{ $header }}</h4>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                {{ trans('actions.delete_this', ['content_type' => $content_type]) }}:
                <b id="content-name">{{ $name }}</b>
                ?
            </div>
            <div class='modal-footer'>

                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method('delete')

                    <button type="submit" id="delete-submit" class='btn btn-danger'>
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ $delete_text }}
                    </button>
                </form>

                @if (isset($cancel))
                    <div type='button' class='btn btn-default' data-bs-dismiss='modal'>{{ $cancel }}</div>
                @endif

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
