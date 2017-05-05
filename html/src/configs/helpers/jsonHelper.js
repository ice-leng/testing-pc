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
                    rules[i] = params[name][i];
                }
                data[name] = rules;
            }
        }
        return data;
    }
}

export default new JsonHelper();
