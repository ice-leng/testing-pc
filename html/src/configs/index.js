/**
 * Created by lengbin on 2017/2/16.
 */

class Config {
    rootUrl() {
        return 'http://www.tester.com';
    }

    parseParams(params) {
        let urlParams = '';
        if (params) {
            let arr = [];
            for (let key in params) {
                let param = params[key];
                if (param !== undefined) {
                    arr.push(encodeURIComponent(key) + '=' + encodeURIComponent(param));
                }
            }
            urlParams = arr.join('&');
        }
        return urlParams;
    }
}

export default new Config();
