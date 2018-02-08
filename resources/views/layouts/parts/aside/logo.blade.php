
<section class="content">
    <div class="inner aside-inner-img editable">
        @if(isAdmin())
            <form method="POST" action="/update_image/undo/logo">
                {!! csrf_field() !!}
                <button title="Rétablir l'ancien logo" href="/update_image/undo/logo" data-toggle="tooltip" data-placement="top" data-name="undo-logo" class="btn btn-edit undo-logo undo-img btn-default">
                    <span class="fa fa-undo"></span>
                </button>
            </form>
            {!!
                printButtonContent("logo",
                                    ['title' => 'Modifier le logo'],
                                     'update-logo update-img',
                                     'upload',
                                     'fa')
            !!}
        @endif
        <img src="{{ url('uploads/logo.png') }}" alt="">
    </div>
</section>