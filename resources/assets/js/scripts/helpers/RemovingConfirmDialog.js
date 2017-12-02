/**
 * Created by Utilisateur on 07/08/2017.
 */

import * as _ from "underscore";
import Exception from "../libs/Exception";

export default class RemovingConfirmDialog {

    constructor() {
        this._title = null;
        this._message = null;
        this._callback = null;
    }


    set title(value) {
        this._title = value;
    }

    set message(value) {
        this._message = value;
    }

    set callback(value) {
        this._callback = value;
    }


    get title() {
        return this._title;
    }

    get message() {
        return this._message;
    }

    get callback() {
        return this._callback;
    }

    build() {
        if (this.title === null || this.message === null || this.callback === null || !_.isFunction(this.callback))
            throw new Exception('The title and the message must be defined, and the callback must be a function.');

        return bootbox.confirm({
            title: this.title,
            size: "small",
            message: "<p align='center'>" + this.message + " </p> <p align='center' class='text-error'><b>Attention, cette action est irréversible !" +
            " </b></p>",
            callback: (choice) => {
                if (choice)
                    this.callback();
            },
        });
    }

    show() {
        return this.build();
    }
}