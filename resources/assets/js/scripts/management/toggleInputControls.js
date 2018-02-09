import Flash from "../libs/flash/Flash";
import {inputFocusout} from "./editUserInfos";
import KeyInputBuffer from "../helpers/KeyInputBuffer";
import Key from "../libs/Key";

export function toggleInput() {
    $('[data-toggle="input"]').click(function () {
        toggleInputClicked($(this));
    });
}

export function toggleInputClicked(el) {
    if (el.find('input').length === 0) {
        const td = el;
        const padding = td.css('padding');
        let content = td.html().trim();
        let input = $('<input class="form-control input-sm" />');
        input.val(content);

        if (td.data('input-type') === 'time' && content.length === 0) {
            input.attr('placeholder', 'Format : hh:mm. Ex : 8:00, 8:30, 08:30.');
        }

        if (td.data('max-length') != null) {
            input.attr('maxlength', td.data('max-length'));
        }
        td.html(input);
        td.css('padding', '0');
        input.focus();
        input.keydown(function (ev) {
            console.log(ev.which);
            // ev.preventDefault();lt
            if (ev.which === Key.TAB) {
                onTabPressed(input, KeyInputBuffer.isPressed(Key.CTRL) ? -1 : 1);
                return false;
            }
            else if (ev.which === Key.ENTER) {
                onEnterPressed(input);
            }
            else if (ev.which === Key.ESCAPE) {
                onEscapePressed(input, content);
            }

        });
        input.focusout(async function () {
            if (content !== input.val()) {
                try {
                    content = await inputFocusout(input);
                }
                catch (msg) {
                    Flash.error(msg);

                    td.html(content);
                    input.remove();
                    td.attr('data-toggle', 'input');
                    td.css('padding', padding);
                }
                finally {
                    td.html(content);
                    input.remove();
                    td.attr('data-toggle', 'input');
                    td.css('padding', padding);
                }
            }
            else {
                td.html(content);
                input.remove();
                td.attr('data-toggle', 'input');
                td.css('padding', padding);
            }
        });
    }
}

function onEscapePressed(input, content) {
    input.val(content);
    input.focusout();
}

function onEnterPressed(input) {
    input.focusout();
}

function onTabPressed(target, toAdd = 1) {
    const tdParent = target.parents('td');
    const tr = target.parents('tr');

    if (tr == null) {
        return;
    }

    const tds = tr.children('td[data-toggle="input"]').toArray();
    const index = tds.indexOf(tdParent[0]);
    const nextIndex = index + toAdd;

    if (nextIndex >= 0 && nextIndex < tds.length) {
        tds[nextIndex].click();
    }
}