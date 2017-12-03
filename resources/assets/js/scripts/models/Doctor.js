/**
 * Created by Utilisateur on 07/08/2017.
 */

import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
import Model from "../libs/Model";

export default class Doctor extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'phone', 'starts_at', 'ends_at', 'resume', 'description']);
    }

    static getClass() {
        return Doctor;
    }

    static getBaseApiUrl() {
        return 'doctors';
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get phone() {
        return this._phone;
    }

    set phone(value) {
        this._phone = value;
    }

    get starts_at() {
        return this._starts_at;
    }

    set starts_at(value) {
        return this._starts_at;
    }

    get ends_at() {
        return this._ends_at;
    }

    set ends_at(value) {
        return this._ends_at;
    }

    get resume() {
        return this._resume;
    }

    set resume(value) {
        return this._resume;
    }

    get description() {
        return this._description;
    }

    set description(value) {
        return this._description;
    }

    // get user(){
    //     return this._user;
    // }

    static get(id, params = "") {
        return new Promise((resolve, reject) => {
            Api.get('doctors/' + id + "?" + params)
                .done((response) => {
                    // console.log(response);
                    if (response === null || response.id === null) {
                        resolve(null);
                    } else {
                        resolve(new Doctor(response));
                    }
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    static create(data, params = "") {
        return new Promise((resolve, reject) => {
            Api.sendData('doctors?' + params, 'POST', data)
                .done((response) => {
                    // console.log(response);
                    resolve(new Doctor(response));
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    update(params = "") {
        // console.log(this);
        return new Promise((resolve, reject) => {
            Api.sendData('doctors/' + this.id + "?" + params, 'PUT', this.toJson())
                .done((response) => {
                    console.log(response);
                    const news = new Doctor(response);
                    Flash.success("Le kiné a bien été modifié !");
                    resolve(news);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier le kiné. Si le problème persiste, contactez l\'administrateur.');
                    reject(error);
                });
        });
    }

    static remove(id) {
        return new Promise((resolve, reject) => {
            Api.sendData('doctors/' + id, 'DELETE')
                .done((response) => {
                    Flash.success('Le kiné a bien été supprimé.');
                    resolve(response);
                })
                .fail((error) => {
                    Flash.error('Une erreur est survenue, l\'utilisateur n\'a pas été supprimé.');
                    reject(error);
                });
        });
    }
}