/**
 * Created by Utilisateur on 08/09/2017.
 */
import Model from "../libs/Model";
import RegexpPattern from "../helpers/RegexpPattern";
import DAO from "./DAO";

export default class Contact extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'created_at', 'updated_at', 'type', 'value', 'description', 'doctor_id', 'name']);
    }

    static newInstance(...args){
        return new Contact(...args);
    }

    static async getTypeOfValue(value) {
        const array = ['phone', 'email', 'link'];

        for (let i = 0; i < array.length; i++) {
            if (RegexpPattern.getRegexpFromPattern(array[i]).test(value)) {
                return array[i].toUpperCase();
            }
        }

        return 'ADDRESS';
    }

    static get(id, params = "") {
        return DAO.get(this, id, params);
    }

    static create(data, params = "") {
        return DAO.create(this, data, params)
    }

    update(params = "") {
        return DAO.update(this, params);
    }

    delete(params = ""){
        return DAO.delete(this, params);
    }

    static remove(id, params = "") {
        return DAO.deleteFromId(this, id, params);
    }
}