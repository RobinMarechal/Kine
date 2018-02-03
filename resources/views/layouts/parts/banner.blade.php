<div id="banner" class="img-banner-block editable">
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
    {{--<button title="" data-namespace="contents" data-toggle="tooltip" data-placement="top" data-name="img--banner"
            class="btn btn-top-right btn-primary update-banner" data-original-title="Modifier la photo de couverture">
        <span class="fa fa-upload"></span>
    </button>--}}
    <img src="{{url('storage/banner.png')}}" alt="" class="img-banner">
</div>