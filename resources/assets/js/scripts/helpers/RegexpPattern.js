const patterns = {
    phone: '((\\+\\d{2})|0)\\d{9}',
    email: '^([A-Z|a-z|0-9](\\.|_|-){0,1})+[A-Z|a-z|0-9]\\@(\\w+\\.)?([A-Z|a-z|0-9|-])+((\\.){0,1}[A-Z|a-z|0-9]){2}\\.[a-z]{2,3}$',
    link: '(https?:\\/\\/)?([\\da-z.-]+\\.[a-z.]{2,6}|[\\d.]+)([\\/:?=&#][\\da-z.-]+)*[\\/?]?',
    time: '(0[0-9]|1[0-9]|2[0-3]|\\d):([0-5]?[0-9])$',
};

export default class RegexpPattern {

    static getRegexpFromPattern(pattern) {
        return new RegExp(RegexpPattern.getStringRegexpFromPattern(pattern));
    }

    static getStringRegexpFromPattern(pattern) {
        if(pattern == null)
            return '(.)';

        if (pattern.indexOf('|') != -1) {
            const patts = pattern.split('|');
            let array = [];
            for (let i = 0; i < patts.length; i++) {
                if (patterns[patts[i]] == null) {
                    return '(.)';
                }

                array.push(patterns[patts[i]]);
            }

            return array.join('|');
        }

        if (patterns[pattern] == null) {
            return '(.)';
        }

        return '(' + patterns[pattern] + ')';
    }
}