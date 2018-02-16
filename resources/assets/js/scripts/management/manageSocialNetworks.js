import SocialNetwork from '../models/SocialNetwork';
import DAO from '../models/DAO';
import Flash from '../libs/flash/Flash';
import RegexpPattern from '../helpers/RegexpPattern';
import Key from '../libs/Key';

function buildRow(sn, logoList) {
    return `<tr data-id="${sn.id}" class="hover-container">
    <td>${buildSelect(logoList, sn.type)}</td>
    <td>
        <input class="input-bottom-border input-sm form-control" data-name="link" type="text" value="${sn.link}" />
    </td>
    <td class="no-padding-right">
        <input class="input-bottom-border input-sm form-control" data-name="tooltip" type="text" value="${sn.tooltip === null ? '' : sn.tooltip}" />
    </td>
    <td class="controls"> 
        <a class="show-on-hover pointer show-on-hover-container btn-table-control fit-height pointer"
            title="Supprimer cette ligne"
            data-toggle="tooltip"
            data-placement="top">
            <i class="far fa-times-circle fa-sm"></i>                    
        </a>
    </td>
</tr>`;
}

function buildSelect(logoList, socialNetworkType, invisible = true) {
    const select = $(`<select class="${invisible ? 'input-invisible' : ''} form-control input-sm" name="type"></select>`);
    select.append('<option disabled selected value="0"> Sélectionnez...</option>');

    for (const type of logoList) {
        const option = $(`<option value="${type.toUpperCase()}"> ${('_' + type).camelCase()} </option>`);
        if (socialNetworkType && socialNetworkType.toLowerCase() === type.toLowerCase()) {
            option.attr('selected', true);
        }

        select.append(option);
    }

    return select;
}

function builtEmptyTable() {
    return $(`<table class="table table-hover table-td-no-padding">
    <thead>
        <td class="bold" width="135">Type : 
            <i class="help far fa-question-circle" 
                title="Ce champs est calculé selon l'URL insérée dans le champs 'Lien'. Il est cependant possible que certaines URL ne soient pas correctement reconnues.">
            </i>
        </td>
        <td class="bold">Lien : </td>    
        <td class="bold">Description (tooltip) : </td>    
        <td width="50"></td>
    </thead>    
    <tbody></tbody>
    
    <tfoot>
            <tr>
                <td></td>
            </tr>
        <tr>
            <td colspan="4" class="bold">Ajouter un réseau social : </td>
        </tr>
        <tr data-id="-1">
            <td>${buildSelect(SocialNetwork.availableLogos(), null, false)}</td>
            <td>
                <input class="input-sm form-control" data-name="link" type="text" />
            </td>
            <td class="no-padding-right">
                <input class="input-sm form-control" data-name="tooltip" type="text"/>
            </td>
            <td>
                <button class="btn btn-primary btn-sm add-contact"><i class="fas fa-plus"></i></button>        
            </td>
        </tr>
    </tfoot>
</table>`);
}

function buildTable(socialNetworkInstances) {
    const availableLogos = SocialNetwork.availableLogos();
    const table = builtEmptyTable();
    const tbody = table.find('tbody');

    const rows = socialNetworkInstances.map((sn) => buildRow(sn, availableLogos));
    tbody.append(rows);

    return table;
}

async function buildDialogHtml() {
    const list = await DAO.all(SocialNetwork);
    return buildTable(list);
}

function addLogoToTemplateFooter(sn) {
    const container = $('.networks .logo-list');
    const a = $(`<a data-id="${sn.id}" 
class="footer-social-network-logo" 
href="${sn.link}" 
target="_blank"> 
</a>`);

    const img = $(`<img src="${sn.logoPath()}" 
data-toggle="tooltip" 
data-placement="top" 
title="${sn.tooltip}"
class="social-network-logo"> `)

    img.tooltip();
    a.append(img);
    container.append(a);
}

async function handleFormSubmit(table, tbody, tfoot) {
    const typeField = tfoot.find('select');
    const linkField = tfoot.findByAttr('data-name', 'link');
    const tooltipField = tfoot.findByAttr('data-name', 'tooltip');

    let error = false;

    const type = typeField.val();
    let link = linkField.val();
    const tooltip = tooltipField.val();

    if (!link.includes('://'))
        link = 'http://' + link;

    const data = {type, link, tooltip};

    linkField.removeClass('has-error');
    if (!RegexpPattern.getRegexpFromPattern('link').test(link)) {
        linkField.addClass('has-error');
        error = true;
    }

    if (error) {
        return false;
    }

    try {
        const created = await DAO.create(SocialNetwork, data);
        const builtRow = $(buildRow(created, SocialNetwork.availableLogos()));
        console.log(builtRow.find('.btn-table-control'));
        builtRow.find('.btn-table-control').click(handleDeleteEvent);
        tbody.append(builtRow);
        addLogoToTemplateFooter(created);
        Flash.success('Le réseau social a bien été ajouté.');

        tooltipField.val('');
        linkField.val('');
        typeField.val(0);
    }
    catch (e) {
        console.log(["manageSocialNetworks#prepareFormEventHandlers", e]);
        Flash.error("Une erreur est survenue, le réseau social n'a pas été enregistré.");
    }

}

function prepareFormEventHandlers(table) {
    const tfoot = table.find('tfoot');
    const tbody = table.find('tbody');
    const select = tfoot.find('select');
    const fieldLink = tfoot.findByAttr('data-name', 'link');
    const btn = tfoot.find('button');
    fieldLink.on('input', (ev) => updateSelectFunctionOfLink(select, $(ev.currentTarget).val()));
    btn.click(() => handleFormSubmit(table, tbody, tfoot));
}

function updateSelectFunctionOfLink(select, link) {
    if (!link)
        return;

    let type;
    link = link.includes('://') ? link.split('/')[2] : link.split('/')[0];

    if (!link)
        return;

    if (link.includes('faceb')) {
        type = 'FACEBOOK';
    }
    else if (link.includes('twit')) {
        type = 'TWITTER';
    }
    else if (link.includes('goo')) {
        type = 'GOOGLE_PLUS';
    }
    else if (link.includes('yout')) {
        type = 'YOUTUBE';
    }
    else if (link.includes('linke')) {
        type = 'LINKEDIN';
    }
    else if (link.includes('pint')) {
        type = 'PINTEREST';
    }
    else {
        type = 0;
    }

    select.val(type);
}

async function handleSelectChangeEvent(select) {
    const id = select.parents('tr').data('id');
    const type = select.val();

    try {
        const sn = await DAO.update(new SocialNetwork({type, id}));
        select.val(sn.type);
        $('.networks .logo-list').findByData('id', id).find('img').prop('src', sn.logoPath());
    }
    catch (e) {
        Flash.error("Une erreur est survenue, les données n'ont pas été modifiées...");
        console.log(['manageSocialNetworks#handleSelectChangeEvent', e]);
    }
}

function prepareSelectChangeHandler(selects) {
    selects.change(function () {
        handleSelectChangeEvent($(this));
    });
}

async function handleLinkFieldChangeEvent(field) {
    const tr = field.parents('tr');
    const select = tr.find('select');
    const id = tr.data('id');
    let link = field.val();
    const type = select.val();

    if (!link.includes('://'))
        link = 'http://' + link;

    try {
        const sn = await DAO.update(new SocialNetwork({link, type, id}));
        field.val(sn.link);
        select.val(sn.type);
        const aTag = $('.networks .logo-list').findByData('id', id);
        aTag.attr('href', sn.link);
        aTag.find('img').prop('src', sn.logoPath());
    }
    catch (e) {
        Flash.error("Une erreur est survenue, les données n'ont pas été modifiées...");
        console.log(['manageSocialNetworks#handleLinkFieldChangeEvent', e]);
    }
}

function prepareBodyLinkFieldsChangeHandler(linkFields) {
    linkFields.keyup((ev) => {
        if (ev.which === Key.ENTER) {
            $(ev.currentTarget).blur();
        }
    });

    linkFields.on('input', function () {
        const field = $(this);
        updateSelectFunctionOfLink(field.parents('tr').find('select'), field.val());
    });

    linkFields.focusout(function () {
        handleLinkFieldChangeEvent($(this));
    });
}

async function handleTooltipFieldChangeEvent(field) {
    const id = field.parents('tr').data('id');
    const tooltip = field.val();
    try {
        const sn = await DAO.update(new SocialNetwork({tooltip, id}));
        field.val(sn.tooltip);
        $('.networks .logo-list').findByData('id', id).find('img').attr('data-original-title', sn.tooltip);
    }
    catch (e) {
        Flash.error("Une erreur est survenue, les données n'ont pas été modifiées...");
        console.log(['manageSocialNetworks#handleTooltipFieldChangeEvent', e]);
    }
}

function prepareBodyTooltipFieldsChangeHandler(tooltipFields) {
    tooltipFields.keyup((ev) => {
        if (ev.which === Key.ENTER) {
            $(ev.currentTarget).blur();
        }
    });

    tooltipFields.focusout(function () {
        handleTooltipFieldChangeEvent($(this));
    });
}

async function handleDeleteEvent() {
    const btn = $(this);
    const tr = btn.parents('tr');
    const id = tr.data('id');

    try {
        await DAO.deleteFromId(SocialNetwork, id);
        tr.remove();
        $(`.footer-social-network-logo[data-id=${id}]`).remove();
        Flash.success("La ligne a bien été supprimée !");
    }
    catch (e) {
        console.log(["manageSocialNetworks#prepareDeleteEventHandler", e]);
        Flash.error('Une erreur est survenue, la ligne n\'a pas été supprimée...');
    }
}

function prepareDeleteEventHandler(tbody) {
    const btns = tbody.find('.btn-table-control');
    btns.click(handleDeleteEvent);
}

function genericEventHandler(instanceId, field, value) {
    let instance = new SocialNetwork({id: instanceId, [field]: value});
    return instance.update();
}

function prepareEventHandlers(table) {
    console.log('1');
    const tfoot = table.find('tfoot');
    const tbody = table.find('tbody');
    prepareFormEventHandlers(table);
    prepareDeleteEventHandler(tbody);
    prepareSelectChangeHandler(tbody.find('select'));
    prepareBodyLinkFieldsChangeHandler(tbody.findByAttr('data-name', 'link'));
    prepareBodyTooltipFieldsChangeHandler(tbody.findByAttr('data-name', 'tooltip'));
}

function showDialog(html) {
    bootbox.dialog({
        title: 'Gérer les réseaux sociaux',
        message: html,
        backdrop: true,
        onEscape: true,
        buttons: {
            validate: {
                label: 'Fermer',
                className: 'btn btn-primary',
            },
        },
    });
}

export default function manageSocialNetworks() {
    $('[data-manage="social-networks"]').click(async function () {
        const html = await buildDialogHtml();
        prepareEventHandlers(html);
        showDialog(html);
    });
};