/**
 * Created by Utilisateur on 12/07/2017.
 */
import FlashMessage from "./FlashMessage";

export default class Flash {
    static async display(message, type = "error", delay = null) {
        return new Promise(resolve => {
            if(message instanceof FlashMessage)
                message = message.message;

            delay = delay == null ? 2000 : delay;

            var html = '<div title="Cliquez pour masquer le message" id="alert" class="alert js-alert alert-' + type + '">' + message + '</div>';
            $('#alert').remove();
            $('body').append(html);
            $('#alert.js-alert').animate({'opacity': '+0.9'}, 200);
            $('#alert.js-alert').delay(delay).animate({'opacity': '-1.2'}, 1000, function () {
                $(this).remove();
                resolve();
            });
        });
    }

    static async error(message, delay = null) {
        if(message instanceof FlashMessage)
            message = message.message;
        return Flash.display(message, "danger", delay);
    }

    static async success(message, delay = null) {
        if(message instanceof FlashMessage)
            message = message.message;
        return Flash.display(message, "success", delay);
    }
}