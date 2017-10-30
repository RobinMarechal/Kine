/**
 * Created by Utilisateur on 06/08/2017.
 */
import Flash from "../libs/Flash";
import Api from "../libs/Api";

export default class Article {

    constructor(obj = null) {
        if (obj !== null) {
            this._id = obj.id;
            this._deleted_at = obj.deleted_at;
            this._created_at = obj.created_at;
            this._updated_at = obj.updated_at;
            this._user_id = obj.user_id;
            this._title = obj.title;
            this._content = obj.content;
            this._views = obj.views;
            this._picture = obj.picture;
        }
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

    toJson() {
        return {
            id: this.id,
            deleted_at: this.deleted_at,
            created_at: this.created_at,
            updated_at: this.updated_at,
            user_id: this.user_id,
            title: this.title,
            content: this.content,
            picture: this.picture,
            views: this.views,
        }
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