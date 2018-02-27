import Doctor from "../models/Doctor";
import Flash from "../libs/flash/Flash";
import Helper from "../helpers/Helper";
import FA from "../helpers/FA";
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
    otherCoo.append('<hr>');
    otherCoo.append('<h4>Autres coordonnées :</h4>');
    // starts_at and ends_at.

    if (doctor.contacts.length > 0) {
        principalCoo.addClass('col-md-12');
        otherCoo.addClass('col-md-12');
    }
    else {
        principalCoo.addClass('col-md-12');
    }

    if (doctor.starts_at != null && doctor.ends_at != null) {
        let pHoraires = `<p>
    <i aria-hidden="true" class="far fa-clock list-icon"></i>
    Horaires : ${Helper.timeToFormat(doctor.starts_at, 'H:i')} - ${Helper.timeToFormat(doctor.ends_at)} 
</p>`;
        principalCoo.append(pHoraires);
    }

    // email
    let pMail = `<p>
    <a href="mailto:${doctor.user.email}">
        <i aria-hidden="true" class="far fa-envelope list-icon"></i>
        ${doctor.user.email}
    </a>
</p>`;
    principalCoo.append(pMail);


    // phone
    if (doctor.phone != null) {
        principalCoo.append(`<p><a href="tel:${doctor.phone} align="center"> ${FA.of('phone', true)}${doctor.phone}</a></p>`);
    }

    // other contacts

    for (let i = 0; i < doctor.contacts.length; i++) {
        const contact = doctor.contacts[i];
        const hrefPrefix = (contact.type === "PHONE" ? 'tel:' : (contact.type === 'EMAIL' ? 'mailto:' : (contact.type === 'ADDRESS' ? 'https://www.google.fr/maps?q=' : '')));
        const iconClass = (contact.type === "PHONE" ? 'phone' : (contact.type === 'EMAIL' ? 'envelope' : (contact.type === 'ADDRESS' ? 'map-marker' : 'link')));

        let p = `<p>
    <a href="${hrefPrefix}${contact.value}" target="_blank" data-toggle="tooltip" title="${contact.name}">
        <i aria-hidden="true" class="fas fa-${iconClass} list-icon"></i>
        ${contact.display != null ? contact.display : contact.value}
    </a>
</p>`;
        otherCoo.append(p);
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

    try {
        bootbox
            .dialog({
                title: Helper.loading({size: '1x', align: 'left'}),
                message: Helper.loading(),
                size: 'small',
                backdrop: true,
                onEscape: true,
            })
            .on('shown.bs.modal', async function () {
                const that = $(this);

                const doctor = await Doctor.get(doctorId, "with=contacts,user");
                const html = buildHtml(doctor);

                that.find('.modal-title').html(doctor.name);
                that.find('.modal-body').html(html);
            });
    }
    catch (e) {
        console.log(["footerDoctors#showDoctorDialog", e]);
        Flash.error("Une erreur est survenue, impossible d'afficher les informations concernant l'utilisateur. Veuillez recharger la page et réessayer.");
    }
}

export default function footerDoctors() {
    $(".footer-doctor-name").click(function () {
        showDoctorDialog($(this));
    });
}