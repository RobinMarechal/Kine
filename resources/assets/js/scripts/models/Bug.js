/**
 * Created by Utilisateur on 06/08/2017.
 */
import Model from "../libs/Model";
import DAO from "./DAO";

export default class Bug extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'created_at', 'solved_at', 'description', 'reporter_ip', 'user_id', 'summary']);
    }

    static newInstance(...args){
        return new Bug(...args);
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