const patterns = {
    phone: /^((\+[0-9]{2})|0)[0-9]{9}$/,
    email: /^([A-Z|a-z|0-9](\.|_|-)?)+[A-Z|a-z|0-9]@(\w+\.)?([A-Z|a-z|0-9|-])+((\.)?[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/,
    link: /^(https?:\/\/)?([\da-z.-]+\.[a-z.]{2,6}|[\d.]+)([\/:?=&#][\da-z.-]+)*[\/?]?$/,
    time: /^(0[0-9]|1[0-9]|2[0-3]|\d):([0-5]?[0-9])$/,
    varchar: /^.{0,255}$/,
    text: /^.*$/,
};

export default class RegexpPattern {

    static getRegexpFromPattern(pattern) {
        return new RegExp(RegexpPattern.getStringRegexpFromPattern(pattern));
    }

    static getStringRegexpFromPattern(pattern) {
        if (pattern == null) {
            return '(.)';
        }

        console.log(pattern);

        if (pattern.indexOf('|') != -1) {
            const arr = pattern.split('|');
            let array = [];
            for (let i = 0; i < arr.length; i++) {
                if (patterns[arr[i]] == null) {
                    return '(.)';
                }

                array.push(patterns[arr[i]].toString());
            }

            return array.join('|');
        }

        if (patterns[pattern] == null) {
            return '(.)';
        }

        return patterns[pattern];
    }
}