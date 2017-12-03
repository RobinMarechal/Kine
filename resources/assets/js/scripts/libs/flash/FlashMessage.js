export default class FlashMessage {

    constructor(message) {
        this.message = message;
    }

    static message(message) {
        return new FlashMessage(message);
    }

    toString() {
        return this.message;
    }
}