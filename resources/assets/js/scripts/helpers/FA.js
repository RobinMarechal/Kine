export default class FA {
    static of(type, list = false) {
        return `<i aria-hidden="true" class="fas fa-${type} ${list ? 'list-icon' : ''}"></i>`;
    }
}