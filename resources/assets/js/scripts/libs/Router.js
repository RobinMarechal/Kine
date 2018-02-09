let instance = null;

export default class Router {

    constructor() {
        if (!instance) {
            instance = this;
        }

        this.routes = new Map();

        return instance;
    }

    static getInstance() {
        return instance === null ? new Router() : instance;
    }

    static addRoute(route, callbacks, name = null) {

        let router = Router.getInstance();

        if (!Array.isArray(callbacks))
            callbacks = [callbacks];

        let group = router.routes.get(route);

        if (group != null && group.callbacks != null) {
            callbacks = callbacks.concat(group.callbacks);
        }

        router.routes.set(route, {
            callbacks,
            name,
        });
    }

    static getRouteActions(url) {

        let router = Router.getInstance();

        for (let [path, obj] of router.routes.entries()) {
            const regexp = new RegExp(path);
            if (regexp.test(url)) {
                return obj.callbacks;
            }
        }
        return [];
    }

    static trigger() {
        const url = window.location.pathname;
        const actions = Router.getRouteActions(url);

        actions.forEach(action => action());
    }
}