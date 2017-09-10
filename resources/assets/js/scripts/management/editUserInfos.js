import Api from "../libs/Api";
import RegexpPattern from "../helpers/RegexpPattern";

export function inputFocusout(input) {

    const td = $(input).parents('td');
    const tr = td.parents('tr');

    const field = td.data('field');
    const patternStr = td.data('pattern');
    const regexp = RegexpPattern.getRegexpFromPattern(patternStr);

    let data = {};
    data[field] = input.val();

    const id = tr.data('id');
    const namespace = tr.data('namespace');

    if (regexp.test(data[field]) == false) {
        return false;
    }

    return new Promise((resolve, reject) => {
        Api.sendData(namespace + '/' + id, 'PUT', data)
            .done((data) => {
                resolve(data);
            })
            .fail((error) => {
                reject(error);
            });
    });
}