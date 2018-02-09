export default class Form{
    static label(text = null)
    {
        let field = $('<label></label>');
        field.addClass('label-control');
        field.html(text);

        return field;
    }

    static input(name, id = null, value = null)
    {
        if(id === null)
            id = name;

        let field = $('<input/>');
        field.addClass('form-control');
        field.prop('id', id);
        field.attr('name', name);
        field.val(value);

        return field;
    }



    static textarea(name, id = null, value = null)
    {
        if(id === null)
            id = name;

        let field = $('<textarea></textarea>');
        field.addClass('form-control');
        field.prop('id', id);
        field.attr('name', name);
        field.html(value);

        return field;
    }

    static formGroup()
    {
        let div = $('<div></div>');
        div.addClass('form-group');

        return div;
    }

}