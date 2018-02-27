import FlashMessage from "./FlashMessage";

let nbAlertRunning = 0;

export default class Flash {
    static async display(message, type = "error", delay = null) {
        return new Promise(resolve => {
            if (message instanceof FlashMessage)
                message = message.message;

            delay = delay == null ? 2000 : delay;

            const jsAlert = $(`<div title="Cliquez pour masquer le message" id="alert" class="alert js-alert alert-${type}">${message}</div>`);
            if(nbAlertRunning > 0){
                jsAlert.css('top', 76 + (37 + 10) * nbAlertRunning) ; // 76 = top, 37 = height, 5 for gap
            }
            // $('#alert').remove();
            nbAlertRunning++;

            $('body').append(jsAlert);

            jsAlert.animate({'opacity': '+0.9'}, 200);
            jsAlert.delay(delay).animate({'opacity': '-1.2'}, 1000, function () {
                $(this).remove();
                nbAlertRunning--;
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