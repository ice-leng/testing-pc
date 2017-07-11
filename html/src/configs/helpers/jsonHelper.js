/**
 * Created by lengbin on 2017/5/2.
 */

class JsonHelper {
    resetPattern(params) {
        let data = {};
        for (let name in params) {
            if (params[name].length > 0) {
                let rules = [];
                for (let i = 0; i < params[name].length; i++) {
                    if (params[name][i].pattern !== undefined) {
                        let pattern = params[name][i].pattern;
                        let reg = new RegExp(pattern);
                        params[name][i].pattern = reg;
                    }
                    if (name === 'url' && params[name][i].pattern !== undefined) {
                        let strRegex = '^((https|http|ftp|rtsp|mms)?://)' +
                            '?(([0-9a-z_!~*().&=+$%-]+: )?[0-9a-z_!~*().&=+$%-]+@)?' +
                            '(([0-9]{1,3}\\.){3}[0-9]{1,3}' +
                            '|' +
                            '([0-9a-z_!~*()-]+\\.)*' +
                            '([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\\.' +
                            '[a-z]{2,6})' +
                            '(:[0-9]{1,4})?' +
                            '((/?)|' +
                            '(/[0-9a-z_!~*().;?:@&=+$,%#-]+)+/?)$';
                        let urlReg = new RegExp(strRegex);
                        params[name][i].pattern = urlReg;
                    }
                    rules[i] = params[name][i];
                }
                data[name] = rules;
            }
        }
        return data;
    }
}

export default new JsonHelper();
