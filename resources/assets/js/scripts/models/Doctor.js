/**
 * Created by Utilisateur on 07/08/2017.
 */

import Model from "../libs/Model";
import DAO from "./DAO";

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


    static newInstance(...args){
        return new Doctor(...args);
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