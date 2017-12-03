import Api from "../libs/Api";
import Flash from "../libs/flash/Flash";
import * as $ from "jquery";
import Model from "../libs/Model";

export default class Skill extends Model{

    constructor(obj = null) {
        super(obj, ['id', 'content', 'created_at', 'updated_at', 'title', 'index', 'doctor_id']);
    }

    get index() {
        return this._index;
    }

    set index(value) {
        this._index = value;
    }

    static get apiUrl() {
        return Api.getBaseUrl() + "/skills";
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
    //         index: this.index,
    //     };
    // }

    static get(id) {
        return new Promise((resolve, reject) => {
            Api.get('skills/' + id)
                .done((response) => {
                    let skill = new Skill(response);
                    resolve(skill);
                })
                .fail((error) => {
                    console.log("Error while trying to get back a skill from the API");
                    reject(null)
                });
        });
    }

    static sendData(data, url = 'api/skills/', httpMethod = 'POST') {
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
            Api.sendData('skills/' + this.id, 'PUT', this.toJson())
                .done((response) => {
                    const skill = new Skill(response);
                    Flash.success('Les données ont bien été modifiées !');
                    resolve(skill);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                    reject(null);
                });
        });
    }

    static create(data) {
        return new Promise((resolve, reject) => {
            Api.sendData('skills', 'POST', data)
                .done((response) => {
                    let skill = new Skill(response);
                    Flash.success('Les données ont bien été modifiées !');
                    resolve(skill);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
                    reject(null);
                });
        });
    }

    static remove(id) {
        return new Promise((resolve, reject) => {
            Api.sendData('skills/' + id, 'DELETE')
                .done((response) => {
                    Flash.success('La rubrique a bien été supprimée.');
                    resolve(response);
                })
                .fail((error) => {
                    Flash.error('Une erreur est survenue, la rubrique n\'a pas été supprimée.');
                    reject(response);
                });
        });
    }
}