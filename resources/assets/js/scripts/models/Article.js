import Model from "../libs/Model";
import DAO from "./DAO";

export default class Article extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'created_at', 'updated_at', 'deleted_at', 'doctor_id', 'title', 'content', 'picture', ' views']);
    }

    static newInstance(...args){
        return new Article(...args);
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