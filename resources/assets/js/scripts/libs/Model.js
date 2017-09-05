/**
 * Created by Utilisateur on 11/07/2017.
 */
import Api from "./Api";

export default class Model {

    constructor(obj, fields) {

        this._fields = fields;

        if (obj != null) {
            for (let prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    let thisProp = fields.indexOf(prop) == -1 ? prop : '_' + prop;
                    this[prop] = obj[prop];
                }
            }
        }
    }


    get fields() {
        return this._fields;
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
            if (this.hasOwnProperty(prop)) {
                if (prop.indexOf('_') == 0)
                    json[prop.substr(1)] = this[prop];
                else
                    json[prop] = this[prop];
            }
        }

        return json;
    }
}