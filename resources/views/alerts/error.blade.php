@if (session($key ?? 'error'))
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        </div>
@endif
