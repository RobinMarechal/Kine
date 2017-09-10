/**
 * Created by Utilisateur on 08/09/2017.
 */
import Model from "../libs/Model";
import Api from "../libs/Api";

export default class Contact extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'deleted_at', 'created_at', 'updated_at', 'type', 'value', 'description', 'user_id', 'name']);
    }


    static create(data) {
        return new Promise((resolve, reject) => {
            Api.sendData('contacts', 'POST', data)
                .done((response) => {
                    resolve(new Contact(response));
                })
                .fail((error) => {
                    reject(error);
                });
        })
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
}