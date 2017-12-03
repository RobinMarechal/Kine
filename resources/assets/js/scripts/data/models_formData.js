export const INPUT_TYPES = {
    INPUT: 'input',
    TEXTAREA: 'textarea',
    DATE: 'date',
    TIME: 'time',
    DATETIME: 'datetime',
};

export const MODELS_FORM_DATA = {};

MODELS_FORM_DATA.abouts = {
    fields: ['title', 'content'],
    title: {
        input: {
            tag: INPUT_TYPES.INPUT,
        },
        label: 'Titre :',
        required: true
    },
    content: {
        input: {
            tag: INPUT_TYPES.TEXTAREA,
        },
        label: 'Texte :',
        required: true
    }
};

MODELS_FORM_DATA.news = {
    fields: ['title', 'content', 'published_at'],
    title: {
        input: {
            tag: INPUT_TYPES.INPUT,
        },
        label: 'Titre : ',
        required: true
    },
    content: {
        input: {
            tag: INPUT_TYPES.TEXTAREA,
        },
        label: 'Contenu : ',
        required: true
    },
    published_at: {
        input: {
            tag: INPUT_TYPES.DATE,
        },
        label: 'Date de publication : ',
    },
};


MODELS_FORM_DATA.events = {
    fields: ['name', 'description', 'article', 'start_date', 'start_time', 'end_date', 'end_time'],
    name: {
        input: {
            tag: INPUT_TYPES.INPUT
        },
        required: true,
        label: "Nom de l'événement : ",
    },
    description: {
        input: {
            tag: INPUT_TYPES.TEXTAREA,
            attributes: {
                rows:5,
            },
            editor: false,
        },
        required: true,
        label: "Description courte : ",
    },
    article: {
        input: {
            tag: INPUT_TYPES.TEXTAREA
        },
        label: "Article ou description longue: ",

    },
    start_date: {
        input: {
            tag: INPUT_TYPES.DATE,
        },
        required: true,
        label: "Date de début de l'événement : ",
    },
    end_date: {
        input: {
            tag: INPUT_TYPES.DATE
        },
        label: "Date de fin de l'événement : ",
    },
    start_time: {
        input: {
            tag: INPUT_TYPES.TIME
        },
        label: "Heure de début de l'événement : ",
    },
    end_time: {
        input: {
            tag: INPUT_TYPES.TIME
        },
        label: "Heure de fin de l'événement : ",
    }
};

