export default class JQueryObject {

    static tag(tagname, selfclosing = false) {
        let str;
        if (selfclosing) {
            str = `<${tagname} />`;
        }
        else {
            str = `<${tagname}> </${tagname}>`;
        }

        return $(str);
    }

    constructor(tagname = null) {
        this._tagname = tagname;
        this._attrs = {};
        this._classes = [];
        this._id = null;
        this._data = {};
        this._jqueryObj = null;
        this._hasChanged = true;
        this._children = [];
        this._icon = null;
        this._title = null;
        this._tooltipPlacement = 'top';
        this._hasTooltip = false;
    }

    get tagname() {
        return this._tagname;
    }

    set tagname(value) {
        this._hasChanged = true;
        this._tagname = value;
        return this;
    }

    get attrs() {
        return this._attrs;
    }

    set attrs(value) {
        this._hasChanged = true;
        this._attrs = value;
        return this;
    }

    get classes() {
        return this._classes;
    }

    set classes(value) {
        this._hasChanged = true;
        this._classes = value;
        return this;
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._hasChanged = true;
        this._id = value;
        return this;
    }

    get data() {
        return this._data;
    }

    set data(value) {
        this._hasChanged = true;
        this._data = value;
        return this;
    }

    get jqueryObj() {
        return this._jqueryObj;
    }

    get hasChanged() {
        return this._hasChanged;
    }

    getJqueryObj() {
        if (this._hasChanged) {
            this.build();
        }

        return this._jqueryObj;
    }

    set icon(type) {
        this._hasChanged = true;
        this._icon = type;
        return this;
    }

    get icon() {
        return this._icon;
    }

    prepareTooltip(title, placement = 'left') {
        this._hasChanged = true;
        this._hasTooltip = true;
        this._title = title;
        this._tooltipPlacement = placement;
        return this;
    }

    set title(value) {
        this._hasChanged = true;
        this._tooltip = value;
        return this;
    }

    set hasTooltip(bool) {
        this._hasChanged = true;
        this._tooltip = bool;
        return this;
    }

    get title() {
        return this._title;
    }

    get tooltipPlacement() {
        return this._tooltipPlacement;
    }

    append(el) {
        if (el instanceof JQueryObject) {
            el = el.build();
        }

        this._children.push(el);
    }

    prepend(el) {
        this._children.insertAt(0, el);
    }

    attr(attr, value) {
        this._hasChanged = true;
        this._attrs[attr] = value;
        return this;
    }

    setData(data, value) {
        this._hasChanged = true;
        this.data[data] = value;
        return this;
    }

    addClass(classname) {
        this._hasChanged = true;
        this._classes.push(classname);
        return this;
    }

    build() {
        if (!this._hasChanged) {
            return this;
        }

        let selfclosing = false;
        let obj;

        if(this._tagname in ['br', 'hr', 'img', 'input']) {
            selfclosing = true;
        }

        if (this._tagname == null) {
            throw "Tagname must not be null.";
        }

        obj = JQueryObject.tag(this._tagname, selfclosing);

        // Classes
        for (let i = 0; i < this._classes.length; i++) {
            obj.addClass(this._classes[i]);
        }

        // Data
        const dataKeys = Object.keys(this._data);
        for (let i = 0; i < dataKeys.length; i++) {
            obj.attr('data-' + obj, dataKeys[i], this.data[dataKeys[i]]);
        }

        // Attributes
        const attrKeys = Object.keys(this._attrs);
        for (let i = 0; i < attrKeys.length; i++) {
            obj.attr(attrKeys[i], this._attrs[attrKeys[i]]);
        }

        // Icon and children
        if (this._icon != null) {
            const icon = $(`<i aria-hidden="true" class="fa fa-${this._icon}"></i>`);
            this._children.insertAt(0, icon);
        }
        for (let i = 0; i < this._children.length; i++) {
            obj.append(this._children[i]);
        }

        // Id
        if (this._id != null) {
            obj.attr('id', this._id);
        }

        // title and tooltip
        if (this._title != null) {
            obj.attr('title', this._title);
            if (this._hasTooltip) {
                obj.attr('data-toggle', 'tooltip');
                obj.attr('data-placement', this._tooltipPlacement);
                obj.tooltip();
            }
        }

        this._jqueryObj = obj;
        this._hasChanged = false;
        return this._jqueryObj;
    }
}