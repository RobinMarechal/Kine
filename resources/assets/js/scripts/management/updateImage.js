import Helper from "../helpers/Helper";

function buildModal(imgTag) {
    const isBanner = imgTag.hasClass('img-banner');
    const form = $(`<form id="modal-form-update-image" method="POST" action="/update_image" enctype="multipart/form-data">
                        ${Helper.csrfToken()}
                        <input type="hidden" name="isBanner" value="${isBanner ? 1 : 0}"/>
                        <div class="form-group text-center">
                            <input type="file" name="image" accept="images/*" class="center"> 
                        </div>
                    </form> `);

    return {
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
                    const parent = form.parent();
                    form.remove();
                    parent.append(`<div align="center">
                                        <i class="fas fa-cog fa-spin fa-2x"></i>
                                  </div>`);
                    return false;
                },
            },
        },
    };
}

function handleImageUpdate(imgTag) {
    const modalObj = buildModal(imgTag);
    const modal = bootbox.dialog(modalObj).show();
}

function handleUndoUpdate(imgTag) {

}


export default function updateImage() {
    $('.update-img').click(function () {
        const img = $(this).siblings('img');
        handleImageUpdate(img);
    });

    $('.undo-img').click(function () {
        const img = $(this).siblings('img');
        handleUndoUpdate(img);
    });
};