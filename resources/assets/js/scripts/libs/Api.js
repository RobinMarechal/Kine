import * as $ from "jquery";

export default class Api {

    static getBaseUrl() {
        return 'http://' + window.location.host + "/api";
    }

    static async sendData(url, httpMethod = 'POST', data = null) {
        if (!url)
            return null;

        if (!url.includes("api"))
            url = "/api/" + url;

        const fetchObj = {
            method: httpMethod,
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        if (data) {
            fetchObj.body = JSON.stringify(data);
        }

        return fetch(url, fetchObj);
    }

    static async get(url, api = true) {
        if (!url)
            return null;

        if (api && !url.includes("api"))
            url = "/api/" + url;

        return fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    }
}