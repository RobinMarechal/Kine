const keyDown = [];

export default class KeyInputBuffer{

    static boot()
    {
        const body = $('body');

        body.keydown(function(ev)
        {
            if(keyDown.indexOf(ev.which) === -1){
                keyDown.push(ev.which);

            }
        });

        body.keyup(function(ev)
        {
            keyDown.remove(ev.which);
        });
    }

    static isPressed(code)
    {
        return keyDown.indexOf(code) !== -1;
    }

    static arePressed(...code)
    {
        for(let i = 0; i < code.length; i++)
            if(!KeyInputBuffer.isPressed(code[i]))
                return false;

        return true;
    }
}

