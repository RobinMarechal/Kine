let instance = null;

export default class Router {


    constructor() {
        if (!instance) {
            instance = this;
        }

        this._routes = {};

        return instance;
    }

    static getInstance() {
        return instance === null ? new Router() : instance;
    }

    static addRoute(route, callbacks, name = null) {

        let router = Router.getInstance();

        if (!Array.isArray(callbacks))
            callbacks = [callbacks];

        let group = router._routes[route];

        if (group != null && group.callbacks != null) {
            callbacks = callbacks.concat(group.callbacks);
        }

        router._routes[route] = {
            callbacks: callbacks,
            name: name
        };
    }

    static getRouteActions(url) {

        let router = Router.getInstance();

        for (var prop in router._routes) {
            if (router._routes.hasOwnProperty(prop)) {

                const regexp = new RegExp(prop);
                if (regexp.test(url)) {
                    return router._routes[prop].callbacks;
                }
            }
        }

    }

    static execute() {
        let router = Router.getInstance();

        const url = window.location.pathname;
        const actions = Router.getRouteActions(url);

        if (actions != null) {
            actions.forEach(function (action) {
                action();
            });
        }
    }
}