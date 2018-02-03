/**
 * Created by Utilisateur on 06/08/2017.
 */

export default class Helper {
    static redirectTo(url) {
        window.location.assign(url);
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
}