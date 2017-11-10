import Flash from "../libs/Flash";
import {inputFocusout} from "./editUserInfos";
import KeyInputBuffer from "../helpers/KeyInputBuffer";

export function toggleInput() {
    $('[data-toggle="input"]').click(function () {
        if ($(this).find('input').length == 0) {
            const td = $(this);
            const padding = td.css('padding');
            let content = td.html().trim();
            let input = $('<input class="form-control input-sm" />');
            input.val(content);

            if (td.data('input-type') == 'time' && content.length == 0) {
                input.attr('placeholder', 'Format : hh:mm. Ex : 8:00, 8:30, 08:30.');
            }

            if (td.data('max-length') != null) {
                input.attr('maxlength', td.data('max-length'));
            }
            td.html(input);
            td.css('padding', '0');
            input.focus();
            input.keydown(function (ev) {
                // ev.preventDefault();
                if (ev.which == 9) {
                    onTabPressed($(this), KeyInputBuffer.isPressed(16) ? -1 : 1);
                    return false;
                }
                else if (ev.which == 13) {
                    onEnterPressed($(this));
                }
                else if (ev.which == 27) {
                    onEscapePressed($(this), content);
                }

            });
            input.focusout(function () {
                if (content != input.val()) {
                    const result = inputFocusout(input);
                    if (result === false) {
                        Flash.error("Veuillez respecter le format.");

                        td.html(content);
                        input.remove();
                        td.attr('data-toggle', 'input');
                        td.css('padding', padding);
                    }
                    else {
                        result
                            .then(data => {
                                content = data[td.data('field')];
                            })
                            .catch(() => {
                                Flash.error('une erreur est survenue, la donnée n\'a pas été modifiée.');
                            })
                            .then(data => {
                                td.html(content);
                                input.remove();
                                td.attr('data-toggle', 'input');
                                td.css('padding', padding);
                            });
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
    });
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