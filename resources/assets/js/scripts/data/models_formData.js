export const INPUT_TYPES = {
    INPUT: 'input',
    TEXTAREA: 'textarea',
    DATE: 'date',
    TIME: 'time',
    DATETIME: 'datetime',
};

export const modelsFormData = {
    abouts: {
        redirect: 'abouts#{slug}',
        fields: ['title', 'content'],
        title: {
            input: {
                tag: INPUT_TYPES.INPUT,
            },
            label: 'Titre :',
        },
        content: {
            input: {
                tag: INPUT_TYPES.TEXTAREA,
            },
            label: 'Texte :',
        }
    },
    news: {
        redirect: 'news/{id}',
        fields: ['title', 'content', 'published_at'],
        title: {
            input: {
                tag: INPUT_TYPES.INPUT,
            },
            label: 'Titre : ',
        },
        content: {
            input: {
                tag: INPUT_TYPES.TEXTAREA,
            },
            label: 'Contenu : ',
        },
        published_at: {
            input: {
                tag: INPUT_TYPES.DATE,
            },
            label: 'Date de publication : ',
        },
    }
};