import Api from "./Api";

export default class Model {

    constructor(obj, fields) {

        this.fields = fields;

        if (obj != null) {
            for (let prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    this[prop] = obj[prop];
                }
            }
        }
    }

    static get baseApiUrl() {
        return Api.getBaseUrl();
    }

    static get apiUrl() {
        throw "Not implemented";
    }

    toJson() {
        let json = {};
        for (let prop in this) {
            if (this.hasOwnProperty(prop) && this[prop] != null) {
                if (prop.indexOf('_') === 0) {
                    json[prop.substr(1)] = this[prop];
                } else {
                    json[prop] = this[prop];
                }
            }
        }

        return json;
    }
}