import SocialNetwork from '../models/SocialNetwork';
import DAO from '../models/DAO';
import Helper from '../helpers/Helper';

function buildRow(sn, logoList) {
    return `<tr data-id="${sn.id}" class="hover-container">
                <td width="130">${buildSelect(logoList, sn.type)}</td>
                <td><input class="input-sm form-control" data-name="link" type="text" value="${sn.link}" /></td>
                <td class="no-padding-right"><input class="input-sm form-control" data-name="tooltip" type="text" value="${sn.tooltip}" /></td>
                <td class="controls" height="51"> 
                    <i class="far fa-times-circle fa-sm pointer show-on-hover show-on-hover-container btn-table-control fit-height"
                        title="Supprimer cette ligne"
                        data-toggle="tooltip"
                        data-placement="top">
                    </i>
                </td>
            </tr>`;
}

function buildSelect(logoList, socialNetworkType) {
    const select = $('<select class="form-control input-sm" name="type"></select>');

    for (const type of logoList) {
        const option = $(`<option value="${type.toUpperCase()}"> ${('_' + type).camelCase()} </option>`);
        console.log(socialNetworkType.toLowerCase() === type);
        if (socialNetworkType.toLowerCase() === type.toLowerCase()) {
            option.attr('selected', true);
        }

        select.append(option);
    }

    return select;
}

function builtEmptyTable() {
    return $(`<table class="table table-hover">
    <thead>
        <td class="bold" width="100">Type : 
            <i class="help far fa-question-circle" 
                title="Ce champs est calculé selon l'URL insérée dans le champs 'Lien'. Il est cependant possible que certaines URL ne soient pas correctement reconnues.">
            </i>
        </td>
        <td class="bold">Lien : </td>    
        <td class="bold">Description (tooltip) : </td>    
        <td width="50"></td>
    </thead>    
    <tbody></tbody>
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

function prepareEventHandlers(html) {

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
        console.log(html);
        prepareEventHandlers(html);
        showDialog(html);
    });
};