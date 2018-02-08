/**
 * Created by Utilisateur on 06/08/2017.
 */
import Model from "../libs/Model";
import DAO from "./DAO";

export default class News extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'deleted_at', 'created_at', 'updated_at', 'doctor_id', 'title', 'content', 'published_at', 'views']);
    }


    static newInstance(...args){
        return new News(...args);
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