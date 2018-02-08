<div id="banner" class="img-banner-block editable">
    @if(isAdmin())
        <form method="POST" action="/update_image/undo/banner">
            {!! csrf_field() !!}
            <button title="Rétablir l'ancienne image de couverture" href="/update_image/undo/banner" data-toggle="tooltip" data-placement="top" data-name="undo-logo" class="btn btn-edit undo-banner undo-img btn-default">
                <span class="fa fa-undo"></span>
            </button>
        </form>
        {!!
            printButtonContent("banner",
                                ['title' => 'Modifier l\'image de couverture', 'data-namespace' => 'contents'],
                                 'update-banner update-img',
                                 'upload',
                                 'fa')
        !!}
    @endif
    <img src="{{url('uploads/banner.png')}}" alt="" class="img-banner">
</div>