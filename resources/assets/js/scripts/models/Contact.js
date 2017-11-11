/**
 * Created by Utilisateur on 08/09/2017.
 */
import Model from "../libs/Model";
import Api from "../libs/Api";
import RegexpPattern from "../helpers/RegexpPattern";

export default class Contact extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'created_at', 'updated_at', 'type', 'value', 'description', 'doctor_id', 'name']);
    }


    set type(value) {
        this._type = value;
    }

    set value(value) {
        this._value = value;
    }

    set description(value) {
        this._description = value;
    }

    set name(value) {
        this._name = value;
    }

    get id() {
        return this._id;
    }

    get created_at() {
        return this._created_at;
    }

    get updated_at() {
        return this._updated_at;
    }

    get type() {
        return this._type;
    }

    get value() {
        return this._value;
    }

    get description() {
        return this._description;
    }

    get name() {
        return this._name;
    }

    get doctor_id() {
        return this._doctor_id;
    }

    set doctor_id(value) {
        this._doctor_id = value;
    }

    static create(data) {
        if (data.type == null) {
            data.type = Contact.getTypeOfValue(data.value);
        }
        return new Promise((resolve, reject) => {
            Api.sendData('contacts', 'POST', data)
                .done((response) => {
                    resolve(new Contact(response));
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    static remove(id) {
        return new Promise((resolve, reject) => {
            Api.sendData('contacts/' + id, 'DELETE')
                .done((response) => {
                    resolve(response);
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    static getTypeOfValue(value) {
        const array = ['phone', 'email', 'link'];

        for (let i = 0; i < array.length; i++) {
            if (RegexpPattern.getRegexpFromPattern(array[i]).test(value)) {
                return array[i].toUpperCase();
            }
        }

        return 'ADDRESS';
    }
}