/**
 * Created by lengbin on 2017/2/15.
 */
import Vue from 'vue';
import Config from 'configs/index';
// import Routers from 'routers/index';
import {Message, MessageBox} from 'element-ui';

// Vue.http.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
Vue.http.headers.common['Content-Type'] = 'application/json';
Vue.http.headers.common['Accept'] = 'application/json';
Vue.http.options.emulateJSON = true;
Vue.http.options.credentials = true;

const dispose = (response) => {
    let status = true;
    let responseBody = response.body;
    let code = responseBody.code;
    let msg = responseBody.message;
    switch (code) {
        case 0:
            msg && Message.success(msg);
            break;
        default:
            msg && MessageBox.alert(msg);
            break;
    }
    return status;
};

export default ({url, body = {}, method = 'get'}) => {
    url = Config.rootUrl() + url;
    return new Promise((resolve, reject) => {
        if (method.toUpperCase() === 'GET') {
            if (body.length > 0) url += ('?' + Config.parseParams(body));
            body = {};
        } else {
            if (body.page) {
                url += ('?' + Config.parseParams({page: body.page}));
                delete body.page;
            }
        }
        Vue.http[method](url, body).then((response) => {
            console.log(response);
            if (dispose(response)) {
                resolve(response);
            } else {
                reject(response);
            }
        }, (response) => {
            console.log(response);
            reject(response);
        });
    });
};

