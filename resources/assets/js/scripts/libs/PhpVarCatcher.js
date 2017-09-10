/**
 * Created by Utilisateur on 06/09/2017.
 */

let vars = {};

export default class PhpVarCatcher {

    static boot() {
        const div = $('#js-vars-relayer');
        const spans = div.children('span');

        for (let i = 0; i < spans.length; i++) {
            const span = $(spans[i]);
            vars[span.data('var-name')] = JSON.parse(span.html());
        }

        div.remove();
    }

    static getAll() {
        return vars;
    }

    static get(name) {
        return vars[name];
    }
}