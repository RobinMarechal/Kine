const map = new Map();

export default class PhpVarMap {

    static boot() {
        const div = $('#js-vars-relayer');
        const spans = div.children('span');

        for (let i = 0; i < spans.length; i++) {
            const span = $(spans[i]);
            map.set(span.data('var-name'), JSON.parse(span.html()));
        }

        div.remove();
    }

    static has(name){
        return map.has(name);
    }

    static get(name) {
        return map.get(name);
    }
}