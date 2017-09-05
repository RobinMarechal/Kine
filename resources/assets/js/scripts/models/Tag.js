/**
 * Created by Utilisateur on 05/09/2017.
 */

import Model from "../libs/Model";
import Api from "../libs/Api";

export default class Tag extends Model {

    constructor(obj) {
        super(obj, ['id', 'name']);
    }

    get id() {
        return this._id;
    }

    get name() {
        return this._name;
    }

    set name(value) {
        this._name = value;
    }

    set id(value) {
        this._id = value;
    }

    static all(params = "") {
        return new Promise((resolve, reject) => {
            Api.get("tags?" + params)
                .done((response) => {
                    if (response === null || response.id === null)
                        reject(null);
                    else {
                        let tags = [];
                        for (let i = 0; i < response.length; i++) {
                            tags.push(new Tag(response[i]));
                        }
                        resolve(tags);
                    }
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }
}