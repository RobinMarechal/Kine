/**
 * Created by Utilisateur on 08/09/2017.
 */
import Model from "../libs/Model";
import Api from "../libs/Api";
import RegexpPattern from "../helpers/RegexpPattern";

export default class Contact extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'deleted_at', 'created_at', 'updated_at', 'type', 'value', 'description', 'user_id', 'name']);
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