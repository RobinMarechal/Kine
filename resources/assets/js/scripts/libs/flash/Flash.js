import FlashMessage from "./FlashMessage";

export default class Flash {
    static async display(message, type = "error", delay = null) {
        return new Promise(resolve => {
            if (message instanceof FlashMessage)
                message = message.message;

            delay = delay == null ? 2000 : delay;

            const html = `<div title="Cliquez pour masquer le message" id="alert" class="alert js-alert alert-${type}">${message}</div>`;
            $('#alert').remove();
            $('body').append(html);

            const jsAlert = $('#alert.js-alert');

            jsAlert.animate({'opacity': '+0.9'}, 200);
            jsAlert.delay(delay).animate({'opacity': '-1.2'}, 1000, function () {
                $(this).remove();
                resolve();
            });
        });
    }

    static async error(message, delay = null) {
        if (message instanceof FlashMessage)
            message = message.message;
        return Flash.display(message, "danger", delay);
    }

    static async success(message, delay = null) {
        if (message instanceof FlashMessage)
            message = message.message;
        return Flash.display(message, "success", delay);
    }
}