import {EVENT_CALLBACKS} from "../data/events_handling";

export const EVENT_TYPES = {
    CREATED: 'creation',
    UPDATED: 'update',
    DELETED: 'deletion',
    BEFORE: 'before',
};

export default class EventHandler {

    /**
     * Call an event
     * @param eventType the type of event (use EVENT_TYPE)
     * @param namespace the REST API resource namespace (.../api/{namespace}/...)
     * @param data the data
     */
    static event(eventType, namespace, data = null) {
        const eventName = eventType + '_' + namespace;
        const callback = EVENT_CALLBACKS[eventName];

        if (callback) {
            return callback(data);
        }

        return data;
    }
}