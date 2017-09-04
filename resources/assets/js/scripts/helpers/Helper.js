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

        if (y < 10)
            y = "0" + y;

        if (m < 10)
            m = "0" + m;

        if (d < 10)
            d = "0" + d;

        format = format.replace('Y', y);
        format = format.replace('m', m);
        format = format.replace('d', d);

        return format;
    }
}