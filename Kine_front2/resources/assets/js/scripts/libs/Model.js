/**
 * Created by Utilisateur on 11/07/2017.
 */
import Api from "./Api";

export default class Model {

    constructor() {
        this._fields = [];
    }

    static get baseApiUrl() {
        return Api.getBaseUrl();
    }

    static get apiUrl() {
        throw "Not implemented";
    }

    toJson() {
        const fields = this.getFields();
        let json = {};

        const size = fields.length;
        for (let i = 0; i < size; i++) {
            const key = fields[i];
            Reflect.set(json, key, Reflect.get(this, key));
        }

        return json;
    }

    static getFields() {
        throw "This method must be extended by child classes";
    }
}