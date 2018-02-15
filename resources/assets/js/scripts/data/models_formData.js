export const INPUT_TYPES = {
    INPUT: 'input',
    TEXTAREA: 'textarea',
    DATE: 'date',
    TIME: 'time',
    DATETIME: 'datetime',
};

export const MODELS_FORM_DATA = {};

MODELS_FORM_DATA.contents = {
    dialogTitle: "{{action}} une rubrique",
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
    }
};

MODELS_FORM_DATA.abouts = {
    dialogTitle: "{{action}} une rubrique",
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
    }
};

MODELS_FORM_DATA.news = {
    formSubmit: true,
    dialogTitle: "{{action}} une news",
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
    formSubmit: true,
    dialogTitle: "{{action}} un événement",
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
                rows: 5,
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


MODELS_FORM_DATA.bugs = {
    dialogTitle: "Signaler un bug",
    fields: ['summary', 'description'],
    callback(modal) {
        const link = modal.find('.close-modal');
        link.click(bootbox.hideAll);
    },
    description: {
        input: {
            tag: INPUT_TYPES.TEXTAREA,
        },
        label: `Détails (optionnel):`,
    },
    summary: {
        input: {
            tag: INPUT_TYPES.INPUT,
        },
        label: `Description courte : 
                <a href="/a-propos#signaler-un-bug" 
                    class="help close-modal" 
                    title="Pourquoi et comment remplir le formulaire" 
                    data-toggle="tooltip" 
                    data-placement="top">
                    <i class="fa fa-question-circle"></i>
                </a>`,
        required: true
    }
};
