import Api from "../libs/Api";
import Model from "../libs/Model";
import DAO from "./DAO";

export default class Skill extends Model{

    constructor(obj = null) {
        super(obj, ['id', 'content', 'created_at', 'updated_at', 'title', 'index', 'doctor_id']);
    }

    static get apiUrl() {
        return Api.getBaseUrl() + "/skills";
    }

    static newInstance(...args){
        return new Skill(...args);
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