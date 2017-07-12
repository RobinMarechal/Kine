/**
 * Created by Utilisateur on 11/07/2017.
 */

class Content extends Model {

    constructor(name) {
        super();
        this._id = -1;
        this._content = null;
        this._createdAt = null;
        this._updatedAt = null;
        this._title = null;
        this._name = name;
    }

    static get apiUrl() {
        return this.baseApiUrl + "/contents";
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
        return this._createdAt;
    }

    set createdAt(value) {
        this._createdAt = value;
    }

    get updatedAt() {
        return this._updatedAt;
    }

    set updatedAt(value) {
        this._updatedAt = value;
    }

    get title() {
        return this._title;
    }

    set title(value) {
        this._title = value;
    }

    static get(name) {
        var content = $.get('contents/' + name)
            .done(function (response) {
                var content = new Content(name);

                content.id = response.id;
                content.content = response.content;
                content.createdAt = response.createdAt;
                content.updatedAt = response.updatedAt;
                content.title = response.title;
                content.name = response.name;

                return content;
            })
            .fail(function (response) {
                console.log("Error while trying to get back a content from the API");
                return null;
            }
        );

        return content;
    }

    update() {
        var promise = this.sendData(name, data);

        promise.done(function (data2) {
            if (data2 != false) {
                $('h1#' + name + '_title').html(data2._title);
                $('div#' + name + '_content').html(data2._content);
                flashMessage('Les données ont bien été modifiées !', 'success');
            }
            else {
                flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
            }
        });

        promise.fail(function (data2) {
            flashMessage('Impossible de modifier les données. Si le problème persiste, contactez l\'administrateur.');
        });
    }
}