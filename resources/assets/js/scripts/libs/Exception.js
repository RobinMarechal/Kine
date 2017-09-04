/**
 * Created by Utilisateur on 30/07/2017.
 */
export default class Exception {
    get message() {
        return this._message;
    }

    set message(value) {
        this._message = value;
    }
    constructor (message = "")
    {
        this._message = message;
    }
}
