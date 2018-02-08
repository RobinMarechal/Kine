import Api from "../libs/Api";
import Helper from "../helpers/Helper";
import ModelFactory from "./ModelFactory";
import User from "./User";

export default class DAO {
    static async get(wanted, id, params = "") {
        const namespace = Helper.getModelNamespace(wanted);
        const response = await Api.get(`${namespace}/${id}?${params}`);
        const json = await response.json();
        return ModelFactory.buildOrNull(wanted, json);
    }

    static async create(wanted, data, params = "") {
        const namespace = Helper.getModelNamespace(wanted);
        const response = await Api.sendData(`${namespace}?${params}`, 'POST', data);
        const json = await response.json();
        return ModelFactory.buildOrNull(wanted, json);
    }

    static async update(obj, params = "") {
        const namespace = Helper.getModelNamespace(obj.constructor.name);
        const response = await Api.sendData(`${namespace}/${obj.id}?${params}`, 'PUT', obj.toJson());
        const json = await response.json();
        return ModelFactory.buildOrNull(obj.constructor.name, json);
    }

    static async delete(obj, params = "") {
        const namespace = Helper.getModelNamespace(obj.constructor.name);
        const response = await Api.sendData(`${namespace}/${obj.id}?${params}`, 'DELETE');
        return await response.json();
    }

    static async deleteFromId(wanted, id, params = "") {
        const namespace = Helper.getModelNamespace(wanted);
        const response = await Api.sendData(`${namespace}/${id}?${params}`, 'DELETE');
        return await response.json();
    }
}