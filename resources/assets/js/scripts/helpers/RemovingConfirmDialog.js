import * as _ from "underscore";
import Exception from "../libs/Exception";

export default class RemovingConfirmDialog {

    constructor() {
        this.title = null;
        this.message = null;
        this.callback = null;
    }

    build() {
        if (this.title === null || this.message === null || this.callback === null || !_.isFunction(this.callback))
            throw new Exception('The title and the message must be defined, and the callback must be a function.');

        const callback = this.callback;
        const msg = this.message;

        return bootbox.confirm({
            title: this.title,
            size: "small",
            message: `<p align="center">${msg}</p><p align="center" class="text-error"><b>Attention, cette action est irréversible !</b></p>`,
            callback: (choice) => {
                if (choice)
                    callback();
            },
        });
    }

    show() {
        return this.build();
    }
}