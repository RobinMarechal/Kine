/**
 * Created by Utilisateur on 12/07/2017.
 */
export default class Flash {
    static display(message, type = "error", delay = null) {
        delay = delay == null ? 2000 : delay;

        var html = '<div title="Cliquez pour masquer le message" id="alert" class="alert js-alert alert-' + type + '">' + message + '</div>';
        $('#alert').remove();
        $('body').append(html);
        $('#alert.js-alert').animate({'opacity': '+0.9'}, 200);
        $('#alert.js-alert').delay(delay).animate({'opacity': '-1.2'}, 1000, function () {
            $(this).remove();
        });
    }

    static ok() {
        var html = '<div id="alert" class="js-alert-success alert-sucess"><span class="glyphicon glyphicon-ok flash"></span></div>';
        $('.js-alert-success').remove();
        $('body').append(html);
        $('#alert.js-alert-success').animate({'opacity': '+0.8'}, 350);
        $('#alert.js-alert-success').delay(500).animate({'opacity': '-1.2'}, 550, function () {
            $(this).remove();
        });
    }

    static error(message, delay = null) {
        Flash.display(message, "danger", delay);
    }

    static success(message, delay = null) {
        Flash.display(message, "success", delay);
    }
}