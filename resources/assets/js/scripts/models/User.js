/**
 * Created by Utilisateur on 07/08/2017.
 */

import Model from "../libs/Model";
import DAO from "./DAO";
import PhpVarCatcher from "../libs/PhpVarCatcher";

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


    static newInstance(...args) {
        return new User(...args);
    }

    isDoctor() {
        return this._doctor_id != null;
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

    static getAuthenticatedUser(){
        return PhpVarCatcher.get('user');
    }
}