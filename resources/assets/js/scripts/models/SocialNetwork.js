import Model from "../libs/Model";
import DAO from "./DAO";

export default class SocialNetwork extends Model {

    constructor(obj = null) {
        super(obj, ['link', 'type', 'tooltip']);
    }

    logoPath() {
        return SocialNetwork.pathOf(this.type);
    }

    static pathOf(type) {
        type = type.toLowerCase();
        return `/img/logos/${type}.png`;
    }

    static availableLogos() {
        const arr = [
            SocialNetwork.LOGO_FACEBOOK,
            SocialNetwork.LOGO_GOOGLE_PLUS,
            SocialNetwork.LOGO_YOUTUBE,
            SocialNetwork.LOGO_LINKEDIN,
            SocialNetwork.LOGO_PINTEREST,
            SocialNetwork.LOGO_TWITTER,
        ];

        return new Set(arr);
    }

    static newInstance(...args) {
        return new SocialNetwork(...args);
    }

    static get(id, params = "") {
        return DAO.get(this, id, params);
    }

    static create(data, params = "") {
        return DAO.create(this, data, params);
    }

    update(params = "") {
        return DAO.update(this, params);
    }

    delete(params = "") {
        return DAO.delete(this, params);
    }

    static remove(id, params = "") {
        return DAO.deleteFromId(this, id, params);
    }
}

SocialNetwork.LOGO_FACEBOOK = 'facebook';
SocialNetwork.LOGO_GOOGLE_PLUS = 'google_plus';
SocialNetwork.LOGO_YOUTUBE = 'youtube';
SocialNetwork.LOGO_LINKEDIN = 'linkedin';
SocialNetwork.LOGO_PINTEREST = 'pinterest';
SocialNetwork.LOGO_TWITTER = 'twitter';