import Doctor from "../models/Doctor";
import Flash from "../libs/Flash";
import Helper from "../helpers/Helper";
import FA from "../helpers/FA";
import JQueryHelper from "../helpers/JQueryHelper";
import JQueryObject from "../libs/JQueryObject";

function buildHtml(doctor) {
    if (doctor == null) {
        Flash.error("Une erreur est survenue, veuillez recharger la page. Si le problème persiste, contactez un administrateur.");
        return '<p align="center">-</p>';
    }

    let html = $('<div></div>');
    html.addClass('show-doctor-dialog');
    html.addClass('row');

    let principalCoo = $('<div></div>');
    principalCoo.addClass('principal-coordinates');
    principalCoo.append('<h4>Coordonnées principales :</h4>');
    let otherCoo = $('<div></div>');

    otherCoo.addClass('other-coordinates');
    otherCoo.append('<h4>Autres coordonnées :</h4>');
    // starts_at and ends_at.

    if (doctor.contacts.length > 0) {
        principalCoo.addClass('col-md-6');
        otherCoo.addClass('col-md-6');
    }
    else {
        principalCoo.addClass('col-md-12');
    }

    if (doctor.starts_at != null && doctor.ends_at != null) {
        let pHoraires = new JQueryObject('p');
        pHoraires.icon = 'clock-o';
        pHoraires.append('Horaires : ' + Helper.timeToFormat(doctor.starts_at, 'H:i') + ' - ' + Helper.timeToFormat(doctor.ends_at));
        principalCoo.append(pHoraires.getJqueryObj());
    }

    // email
    let pMail = new JQueryObject('p');
    let aMail = new JQueryObject('a');
    aMail.icon = 'envelope';
    aMail.append(doctor.user.email);
    aMail.attr('href', 'mailto:' + doctor.user.email);
    pMail.append(aMail);
    principalCoo.append(pMail.getJqueryObj());


    // phone
    if (doctor.phone != null) {
        principalCoo.append('<p><a href="tel:' + doctor.phone + ' align="center"> ' + FA.of('phone') + doctor.phone + '</a></p>');
    }

    // other contacts

    for (let i = 0; i < doctor.contacts.length; i++) {
        const contact = doctor.contacts[i];
        const hrefPrefix = (contact.type == "PHONE" ? 'tel:' : (contact.type == 'EMAIL' ? 'mailto:' : (contact.type == 'ADDRESS' ? 'https://www.google.fr/maps?q=' : '')));
        const iconClass = (contact.type == "PHONE" ? 'phone' : (contact.type == 'EMAIL' ? 'envelope' : (contact.type == 'ADDRESS' ? 'map-marker' : 'link')));

        let p = new JQueryObject('p');
        let a = new JQueryObject('a');
        a.attr('href', hrefPrefix + contact.value);
        a.attr('target', '_blank');
        a.prepareTooltip(contact.name);
        a.icon = iconClass;
        a.append(contact.display != null ? contact.display : contact.value);

        p.append(a);
        otherCoo.append(p.build());
    }

    html.append(principalCoo);
    if (doctor.contacts.length > 0) {
        html.append(otherCoo);
    }

    // Resume
    if (doctor.resume != null) {
        let resume = new JQueryObject('div');
        resume.addClass('col-md-12');
        resume.addClass('text-indent');
        resume.append('<hr />');
        let resumeTitle = new JQueryObject('h4');
        resumeTitle.append('Résumé :');
        let resumeContent = new JQueryObject('p');
        resumeContent.append(doctor.resume);

        resume.append(resumeTitle);
        resume.append(resumeContent);
        html.append(resume.build());
    }


    // Description
    if (doctor.description != null) {
        let description = new JQueryObject('div');
        description.addClass('col-md-12');
        description.addClass('text-indent');
        description.addClass('text-justify');
        description.append('<hr />');
        let descriptionTitle = new JQueryObject('h4');
        descriptionTitle.append('Description : ');

        description.append(descriptionTitle);
        description.append(doctor.description);
        html.append(description.build());
    }


    return html;
}

function showDoctorDialog(el) {
    const doctorId = el.data('id');

    Doctor.get(doctorId, "with=contacts,user")
        .then(doctor => {

            const html = buildHtml(doctor);

            bootbox.dialog({
                title: doctor.name,
                message: html,
                // size: 'small',
                onEscape: true,
            });
        })
        .catch((e) => {
            console.log(e);
            Flash.error("Une erreur est survenue, impossible d'afficher les informations concernant l'utilisateur. Veuillez recharger la page et réessayer.");
        });
}

export default function footerDoctors() {
    const el = ".footer-doctor-name";

    $(el).click(function () {
        showDoctorDialog($(this));
    });
}