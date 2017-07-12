/**
 * Created by Utilisateur on 11/07/2017.
 */

class Model {

    constructor(){}

    static get baseApiUrl()
    {
        return 'http://' + window.location.host + "/api";
    }

    static get apiUrl()
    {
        throw "Not implemented";
    }
}