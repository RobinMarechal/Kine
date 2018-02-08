/**
 * Created by Utilisateur on 11/07/2017.
 */

import Model from "../libs/Model";
import DAO from "./DAO";

export default class Content extends Model{

    constructor(obj = null) {
        super(obj, ['id', 'content', 'created_at', 'updated_at', 'title', 'name', 'doctor_id']);
    }

    static newInstance(...args){
        return new Content(...args);
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

    static async get(id, params = "") {
        return DAO.get(this, id, params);
    }

    static async create(data, params = "") {
        return DAO.create(this, data, params)
    }

    async update(params = "") {
        return DAO.update(this, params);
    }

    async delete(params = ""){
        return DAO.delete(this, params);
    }

    static remove(id, params = "") {
        return DAO.deleteFromId(this, id, params);
    }
}