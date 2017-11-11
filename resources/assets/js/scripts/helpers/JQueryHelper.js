import FA from "./FA";

export default class JQueryHelper {
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

    static addIcon(el, type) {
        JQueryHelper.prependContent(el, FA.of(type));
    }

    static removeIcons(el) {
        el.children('.fa').remove();
    }

    static setIcon(el, type) {
        JQueryHelper.removeIcons(el);
        JQueryHelper.addIcon(el, type);
    }

    static addTooltip(el, title, placement = "top") {
        JQueryHelper.setData(el, 'toggle', 'tooltip');
        JQueryHelper.setData(el, 'placement', placement);
        JQueryHelper.setAttr(el, 'title', title);
    }

    static addClasses(el, ...classes) {
        for (let i = 0; i < classes.length; i++) {
            el.addClass(classes[i]);
        }
    }

    static appendContent(el, content) {
        el.append(content);
    }

    static prependContent(el, content) {
        el.prepend(content);
    }

    static setAttr(el, attr, value) {
        el.attr(attr, value);
    }

    static setData(el, dataname, value) {
        JQueryHelper.setAttr(el, 'data-' + dataname, value);
    }

}