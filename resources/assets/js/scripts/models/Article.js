/**
 * Created by Utilisateur on 06/08/2017.
 */
import Flash from "../libs/Flash";
import Api from "../libs/Api";
import Model from "../libs/Model";

export default class Article extends Model {

    constructor(obj = null) {
        super(obj, ['id', 'created_at', 'updated_at', 'deleted_at', 'user_id', 'title', 'content', 'picture',' views']);
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

    get user_id() {
        return this._user_id;
    }

    set user_id(value) {
        this._user_id = value;
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

    get picture() {
        return this._picture;
    }

    set picture(value) {
        this._picture = value;
    }

    static get(id) {
        return new Promise((resolve, reject) => {
            Api.get('articles/' + id)
                .done((response) => {
                    if (response === null || response.id === null)
                        resolve(null);
                    else
                        resolve(new Article(response));
                })
                .fail((error) => {
                    reject(error);
                });
        });
    }

    static create(data) {
        return new Promise((resolve, reject) => {
            Api.sendData('articles', 'POST', data)
                .done((response) => {
                    resolve(new Article(response));
                })
                .fail((error) => {
                    reject(error);
                });
        })
    }

    update() {
        return new Promise((resolve, reject) => {
            Api.sendData('articles/' + this.id, 'PUT', this.toJson())
                .done((response) => {
                    const news = new Article(response);
                    Flash.success("L'article a bien été modifié !");
                    resolve(news);
                })
                .fail((error) => {
                    Flash.error('Impossible de modifier l\'article. Si le problème persiste, contactez l\'administrateur.');
                    reject(error);
                });
        });
    }

    static remove(id) {
        return new Promise((resolve, reject) => {
            Api.sendData('articles/' + id, 'DELETE')
                .done((response) => {
                    Flash.success('L\'article a bien été supprimé.');
                    resolve(response);
                })
                .fail((error) => {
                    Flash.error('Une erreur est survenue, l\'article n\'a pas été supprimé.');
                    reject(error);
                });
        });
    }
}