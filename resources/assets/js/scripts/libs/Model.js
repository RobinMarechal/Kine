import Api from "./Api";
import Exception from './Exception';

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

    static newInstance(){
        throw new Exception("Method should be overridden");
    }

    static toList(objs = []) {
        return objs.map(this.newInstance);
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