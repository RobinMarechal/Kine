import * as $ from "jquery";
export default class Api {

    static getBaseUrl() {
        return 'http://' + window.location.host + "/api";
    }

    static sendData(url, httpMethod = 'POST', data = null) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        return $.ajax({
            method: httpMethod,
            url: '/api/' + url,
            data: data
        });
    }

    static get(url, api = true) {
        if (api)
            url = '/api/' + url;

        return $.get(url);
    }
}