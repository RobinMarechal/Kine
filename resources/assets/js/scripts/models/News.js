/**
 * Created by Utilisateur on 06/08/2017.
 */
import Flash from "../libs/Flash";
import Api from "../libs/Api";
import Model from "../libs/Model";

export default class News extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'deleted_at', 'created_at', 'updated_at', 'doctor_id', 'title', 'content', 'published_at', 'views']);
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get deleted_at() {
        return this._deleted_at;
    }

    set deleted_at(value) {
        this._deleted_at = value;
    }

    get created_at() {
        return this._created_at;
    }

    set created_at(value) {
        this._created_at = value;
    }

    get updated_at() {
        return this._updated_at;
    }

    set updated_at(value) {
        this._updated_at = value;
    }

    get doctor_id() {
        return this._doctor_id;
    }

    set doctor_id(value) {
        this._doctor_id = value;
    }

    get title() {
        return this._title;
    }

    set title(value) {
        this._title = value;
    }

    get content() {
        return this._content;
    }

    set content(value) {
        this._content = value;
    }

    get published_at() {
        return this._published_at;
    }

    set published_at(value) {
        this._published_at = value;
    }

    get views() {
        return this._views;
    }

    set views(value) {
        this._views = value;
    }

    // toJson() {
    //     return {
    //         id: this.id,
    //         deleted_at: this.deleted_at,
    //         created_at: this.created_at,
    //         updated_at: this.updated_at,
    //         doctor_id: this.doctor_id,
    //         title: this.title,
    //         content: this.content,
    //         published_at: this.published_at,
    //         views: this.views,
    //     }
    // }


    static get(id) {
        return new Promise((resolve, reject) => {
            Api.get('news/' + id)
                .done((response) => {
                    if (response === null || response.id === null) {
                        resolve(null);
                    } else {
                        resolve(new News(response));
                    }
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    static create(data) {
        return new Promise((resolve, reject) => {
            Api.sendData('news', 'POST', data)
                .done((response) => {
                    resolve(new News(response));
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    update() {
        return new Promise((resolve, reject) => {
            Api.sendData('news/' + this.id, 'PUT', this.toJson())
                .done((response) => {
                    const news = new News(response);
                    Flash.success('La news a bien été modifiée !');
                    resolve(news);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier la news. Si le problème persiste, contactez l\'administrateur.');
                    reject(null);
                });
        });
    }

    static remove(id) {
        return new Promise((resolve, reject) => {
            Api.sendData('news/' + id, 'DELETE')
                .done((response) => {
                    Flash.success('La news a bien été supprimée.');
                    resolve(response);
                })
                .fail((error) => {
                    Flash.error('Une erreur est survenue, la news n\'a pas été supprimée.');
                    reject(response);
                });
        });
    }
}