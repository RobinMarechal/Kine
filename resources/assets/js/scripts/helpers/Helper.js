/**
 * Created by Utilisateur on 06/08/2017.
 */

export default class Helper {
    static redirectTo(url) {
        window.location.assign(url);
    }

    static currentDate(dbFormat = true) {
        const date = new Date();
        let year = date.getFullYear();
        let month = date.getMonth() + 1;
        let day = date.getDate();

        if (year < 10) year = '0' + year;
        if (month < 10) month = '0' + month;
        if (day < 10) day = '0' + day;

        if (dbFormat)
            return `${year}-${month}-${day}`;
        else
            return `${day}/${month}/${year}`;
    }

    static currentTime(dbFormat = true) {
        const date = new Date();
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let seconds = date.getSeconds();

        if (hours < 10) hours = '0' + hours;
        if (minutes < 10) minutes = '0' + minutes;
        if (seconds < 10) seconds = '0' + seconds;

        let str = `${hours}:${minutes}`;

        if (dbFormat)
            str += ':' + seconds;

        return str;
    }

    static currentDateTime(dbFormat = true) {
        return this.currentDate(dbFormat) + ' ' + this.currentTime(dbFormat);
    }

    static dateToFormat(date, format = 'd/m/Y') {
        let y = date.getFullYear();
        let m = date.getMonth() + 1;
        let d = date.getDate();

        if (y < 10) {
            y = "0" + y;
        }

        if (m < 10) {
            m = "0" + m;
        }

        if (d < 10) {
            d = "0" + d;
        }

        format = format.replace('Y', y);
        format = format.replace('m', m);
        format = format.replace('d', d);

        return format;
    }


    static timeToFormat(time) {


        let format = "H:i";

        if (time == null) {
            time = "00:00:00";
        }

        if (typeof time === "string") {
            time = new Date("2000-01-01 " + time);
        }


        let h = time.getHours();
        let i = time.getMinutes();

        if (h < 10) {
            h = "0" + h;
        }

        if (i < 10) {
            i = "0" + i;
        }

        format = format.replace('H', h + "");
        format = format.replace('i', i + "");

        return format;
    }

    static csrfToken() {
        const token = $('meta[name=csrf-token]').attr('content');
        return `<input type="hidden" name="_token" value="${token}" />`;
    }

    static snakeCase(str) {
        return str.split(/(?=[A-Z])/).join('_').toLowerCase();
    }

    static camelCase(str) {

    }

    static plural(str) {
        const last = str[str.length - 1];

        if (last == 's')
            return str;

        if (last == 'y')
            return `${str.substring(0, str.length - 1)}ies`;

        return `${str}s`;
    }

    static getModelNamespace(className) {
        if (typeof className === 'function' || typeof className === 'object')
            className = Helper.getRelatedClassName(className);

        return Helper.plural(Helper.snakeCase(className));
    }

    static getRelatedClassName(wanted) {
        if (typeof wanted === 'object')
            return wanted.constructor.name;
        else if (typeof wanted === 'function')
            return wanted.name;
    }

    static loading({size = '5x', align = 'center', pClasses = '', iconClasses = '', title = 'Chargement...'} = {}) {
        return `<p align="${align}" class="no-margin-p loading ${pClasses}">
    <i title="${title}" class="fas fa-cog fa-spin fa-${size} ${iconClasses}"></i>
</p>`;
    }
}