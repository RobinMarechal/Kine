export const config_pikaday = {
    toString(date) {
        let day = date.getDate();
        let month = date.getMonth() + 1;
        const year = date.getFullYear();

        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }

        return `${year}-${month}-${day}`;
    },
    i18n: {
        previousMonth: 'Mois précédent',
        nextMonth: 'Mois suivant',
        months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    }
};