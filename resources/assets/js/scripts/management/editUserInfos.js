import Api from "../libs/Api";
import RegexpPattern from "../helpers/RegexpPattern";

export async function inputFocusout(input) {
    const td = $(input).parents('td');
    const tr = td.parents('tr');

    const field = td.data('field');
    const patternStr = td.data('pattern');
    const regexp = RegexpPattern.getRegexpFromPattern(patternStr);

    let submitted = {};
    submitted[field] = input.val().trim();

    const id = tr.data('id');
    const namespace = tr.data('namespace');

    if (regexp.test(submitted[field]) == false && submitted[field] != "") {
        throw "Format invalide.";
    }

    const result = await Api.sendData(namespace + '/' + id, 'PUT', submitted);
    const response = await result.json();

    if(!response[field]){
        throw "Une erreur est survenue, impossible de mettre la donnée à jour...";
    }

    if(response[field] != submitted[field]){
        throw "Format invalide.";
    }

    return response[field];
}
