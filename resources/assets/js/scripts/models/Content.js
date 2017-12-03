/**
 * Created by Utilisateur on 11/07/2017.
 */

import Flash from "../libs/flash/Flash";
import Api from "../libs/Api";
import Model from "../libs/Model";

export default class Content extends Model{

    constructor(obj = null) {
        super(obj, ['id', 'content', 'created_at', 'updated_at', 'title', 'name', 'doctor_id']);
    }

    static get apiUrl() {
        return Api.getBaseUrl() + "/contents";
    }

    get name() {
        return this._name;
    }

    set name(value) {
        this._name = value;
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get content() {
        return this._content;
    }

    set content(value) {
        this._content = value;
    }

    get createdAt() {
        return this._created_at;
    }

    set createdAt(value) {
        this._created_at = value;
    }

    get updatedAt() {
        return this._updated_at;
    }

    set updatedAt(value) {
        this._updated_at = value;
    }

    get title() {
        return this._title;
    }

    set title(value) {
        this._title = value;
    }

    get doctor_id() {
        return this._doctor_id;
    }

    set doctor_id(value) {
        this._doctor_id = value;
    }

    // toJson() {
    //     return {
    //         id: this.id,
    //         content: this.content,
    //         created_at: this.createdAt,
    //         updated_at: this.updatedAt,
    //         title: this.title,
    //         name: this.name
    //     };
    // }

    static get(id) {
        return new Promise((resolve, reject) => {
            Api.get('contents/' + id)
                .done((response) => {
                    let content = new Content(response);
                    resolve(content);
                })
                .fail((error) => {
                    console.log("Error while trying to get back a content from the API");
                    reject(null)
                });
        });
    }

    static sendData(data, url = 'api/contents/', httpMethod = 'POST') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        return $.ajax({
            method: httpMethod,
            url: url,
            data: data
        });
    }

    update() {
        return new Promise((resolve, reject) => {
            Api.sendData('contents/' + this._id, 'PUT', this.toJson())
                .done((response) => {
                    const res = new Content(response);
                    Flash.success('Les données ont bien été modifiées !', 'success');
                    resolve(res);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                    reject(null);
                });
        })
    }

    // static create(data, callback) {
    //     var promise = Api.sendData(data, 'contents');
    //
    //     promise.done(function (data2) {
    //         if (data2 != false) {
    //             callback(data2);
    //             Flash.success('Les données ont bien été modifiées !', 'success');
    //         }
    //         else {
    //             Flash.error('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
    //         }
    //     });
    //
    //     promise.fail(function (data2) {
    //         Flash.error('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
    //     });
    // }

    static create(data) {
        return new Promise((resolve, reject) => {
            Api.sendData('contents', 'POST', data)
                .done((response) => {
                    let content = new Content(response);
                    Flash.success('Les données ont bien été modifiées !', 'success');
                    resolve(content);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                    reject(null);
                });
        });
    }


    static buildHtmlForm(inputId, inputName, textareaId, textareaName, inputValue = "", textareaValue = "") {


        if (inputName == null)
            inputName = inputId;

        if (textareaName == null)
            textareaName = textareaId;


        let html = $('<div></div>');

        let div1 = $('<div class="form-group"></div>');
        let div2 = $('<div class="form-group"></div>');


        let labelInput = $('<label></label>');

        labelInput.html("Titre :");
        labelInput.addClass('label-control');


        let input = $('<input />');

        input.attr('id', inputId);
        input.attr('type', 'text');
        input.attr('name', inputName);
        input.val(inputValue);
        input.addClass('form-control');


        let labelTextaera = $('<label></label>');

        labelTextaera.html("Texte :");
        labelTextaera.addClass("label-control");


        let textarea = $('<textarea></textarea>');

        textarea.attr('id', textareaId);
        textarea.attr('name', textareaName);
        textarea.addClass('form-control');
        textarea.html(textareaValue);


        div1.append(labelInput);
        div1.append(input);

        div2.append(labelTextaera);
        div2.append(textarea);

        html.append(div1);
        html.append(div2);

        return html;
    }
}