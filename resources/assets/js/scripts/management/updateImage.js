import Helper from "../helpers/Helper";

function buildModal(imgTag) {
    const isBanner = imgTag.hasClass('img-banner');
    const form = $(`
 <form method="POST" action="/update_image" enctype="multipart/form-data">
    ${Helper.csrfToken()}
    <input type="hidden" name="isBanner" value="${isBanner ? 1 : 0}"/>
    <div class="form-group text-center">
        <input type="file" name="image" accept="images/*" class="center">
    </div>
</form> `);

    return bootbox.dialog({
        title: isBanner ? "Modifier l'image de couverture." : "Modifier le logo",
        size: 'small',
        message: form,
        backdrop: true,
        onEscape: true,
        buttons: {
            cancel: {
                label: 'Annuler',
                className: 'btn btn-default',
            },
            validate: {
                label: 'Valider',
                className: 'btn btn-primary',
                callback: function () {
                    form.submit();
                }
            }
        }
    });
}

function handleImageUpdate(imgTag) {
    const modal = buildModal(imgTag);

    modal.show();
}

function handleUndoUpdate(imgTag) {
    
}


export default function updateImage() {
    $('.update-img').click(function () {
        const img = $(this).siblings('img');
        handleImageUpdate(img);
    });

    $('.undo-img').click(function(){
        const img = $(this).siblings('img');
        handleUndoUpdate(img);
    });
};