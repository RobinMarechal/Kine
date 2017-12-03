/**
 * Created by Utilisateur on 07/08/2017.
 */

import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
import Model from "../libs/Model";
export default class User extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'deleted_at', 'created_at', 'updated_at', 'email', 'name', 'facebook_id', 'doctor_id', 'connections']);
    }

    static getClass() {
        return User;
    }

    static getBaseApiUrl() {
        return 'users';
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get deleted_at() {
        return this._deleted_at;
    }

    set deleted_at(value) {
        this._deleted_at = value;
    }

    get created_at() {
        return this._created_at;
    }

    set created_at(value) {
        this._created_at = value;
    }

    get updated_at() {
        return this._updated_at;
    }

    set updated_at(value) {
        this._updated_at = value;
    }

    get email() {
        return this._email;
    }

    set email(value) {
        this._email = value;
    }

    get name() {
        return this._name;
    }

    set name(value) {
        this._name = value;
    }

    get facebook_id() {
        return this._facebook_id;
    }

    set facebook_id(value) {
        this._facebook_id = value;
    }

    get doctor_id() {
        return this._doctor_id;
    }

    set doctor_id(value) {
        this._doctor_id = value;
    }

    isDoctor()
    {
        return this._doctor_id != null;
    }


    static get(id, params = "") {
        return new Promise((resolve, reject) => {
            Api.get('users/' + id + "?" + params)
                .done((response) => {
                    if (response === null || response.id === null) {
                        resolve(null);
                    } else {
                        resolve(new User(response));
                    }
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    static create(data) {
        return new Promise((resolve, reject) => {
            Api.sendData('users', 'POST', data)
                .done((response) => {
                    resolve(new User(response));
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    update(params = "") {
        return new Promise((resolve, reject) => {
            Api.sendData('users/' + this.id + "?" + params, 'PUT', this.toJson())
                .done((response) => {
                    const news = new User(response);
                    // Flash.success("L'utilisateur a bien été modifié !");
                    resolve(news);
                })
                .fail((error) => {
                    // Flash.error('Impossible de modifier l\'utilisateur. Si le problème persiste, contactez l\'administrateur.');
                    reject(error);
                });
        });
    }

    static remove(id) {
        return new Promise((resolve, reject) => {
            Api.sendData('users/' + id, 'DELETE')
                .done((response) => {
                    // Flash.success('L\'User a bien été supprimé.');
                    resolve(response);
                })
                .fail((error) => {
                    // Flash.error('Une erreur est survenue, l\'User n\'a pas été supprimé.');
                    reject(error);
                });
        });
    }
}