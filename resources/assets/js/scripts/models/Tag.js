/**
 * Created by Utilisateur on 05/09/2017.
 */

import Model from "../libs/Model";
import Api from "../libs/Api";
import Article from "./Article";
import DAO from "./DAO";

export default class Tag extends Model {

    constructor(obj) {
        super(obj, ['id', 'name']);
    }

    static async all(){
        const response = await Api.get('tags');
        return await response.json();
    }

    static newInstance(...args){
        return new Tag(...args);
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