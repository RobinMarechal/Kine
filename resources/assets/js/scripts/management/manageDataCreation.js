import FormGenerator from "../helpers/FormGenerator";
import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
import EventHandler, {EVENT_TYPES} from "../libs/EventHandler";
import RemovingConfirmDialog from "../helpers/RemovingConfirmDialog";
import FlashMessage from "../libs/flash/FlashMessage";

function onSubmit(formGenerator) {
    const namespace = formGenerator.namespace;
    let sendDataTo;
    let method = 'POST';
    let obj;

    try {
        obj = formGenerator.buildObject();
    } catch (e) {
        if (e instanceof FlashMessage) {
            Flash.error(e);
            return false;
        }
    }

    console.log("before event call", obj);

    obj = EventHandler.event(EVENT_TYPES.BEFORE, namespace, obj);

    console.log("after event call", obj);

    sendDataTo = namespace;
    if (obj.id) {
        sendDataTo += '/' + obj.id;
        method = 'PUT';
    }

    Api.sendData(sendDataTo, method, obj)
        .then(function (response) {

            if (response.length == 0) {
                throw null;
            }

            if (obj.id && obj.id == response.id) {
                EventHandler.event(EVENT_TYPES.UPDATED, namespace, response);
            } else {
                EventHandler.event(EVENT_TYPES.CREATED, namespace, response);
            }
        })
        .catch(function () {
            if (obj && obj.id) {
                Flash.error("Une erreur est survenue, la donnée n'a pas été modifiée.");
            } else {
                Flash.error("Une erreur est survenue, la donnée n'a pas été créée.");
            }
        });
}

export function dataCreationButtonClicked(button) {
    const namespace = button.data('namespace');

    const generator = FormGenerator.create(namespace);
    generator.onValidate = onSubmit;
    generator.displayInDialog();
}


export function dataUpdatingButtonClicked(button) {
    const namespace = button.data('namespace');
    const dataId = button.data('id');

    Api.get(namespace + '/' + dataId)
        .then((response) => {
            const generator = FormGenerator.create(namespace, response);
            generator.onValidate = onSubmit;
            generator.displayInDialog();
        })
        .catch(() => {
            Flash.error("Une erreur est survenue lors de la récupération des données.");
        });
}

export function dataRemovingButtonClicked(button) {
    const dataId = button.data('id');
    const blockId = button.parents('section').attr('id');
    const namespace = button.data('namespace');

    const dialog = new RemovingConfirmDialog();

    dialog.title = "Supprimer la donnée";
    dialog.message = "Voulez-vous vraime supprimer cette donnée ?";
    dialog.callback = function () {
        Api.sendData(namespace + '/' + dataId, 'DELETE')
            .then((response) => {
                if (!response) {
                    throw null;
                }

                EventHandler.event(EVENT_TYPES.DELETED, namespace, blockId);
            })
            .catch(() => {
                Flash.error("Une erreur est survenue, la donnée n'a pas été supprimée.");
            });
    };

    dialog.show();
}

export default function manageDataCreation() {
    $('.create-data').click(function (ev) {
        ev.preventDefault();
        dataCreationButtonClicked($(this));
    });

    manageDataRemovingAndUpdate();
}

export function manageDataRemovingAndUpdate() {
    $('.update-data').click(function (ev) {
        ev.preventDefault();
        dataUpdatingButtonClicked($(this));
    });

    $('.remove-data').click(function (ev) {
        ev.preventDefault();
        dataRemovingButtonClicked($(this));
    });
}