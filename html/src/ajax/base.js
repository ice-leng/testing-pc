/**
 * Created by lengbin on 2017/2/15.
 */
import Vue from 'vue';
import Config from 'configs/index';
// import Routers from 'routers/index';
import {Message, MessageBox} from 'element-ui';

Vue.http.headers.common['Content-Type'] = 'application/x-www-form-urlencoded';
Vue.http.headers.common['Accept'] = 'application/json';
Vue.http.options.emulateJSON = true;
Vue.http.options.credentials = true;

export default ({url, body = {}, method = 'get', isDispose = true}) => {
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
            let code = response.body.code;
            let msg = response.body.message;
            if (isDispose) {
                switch (code) {
                    case 0:
                        msg && Message.success(msg);
                        resolve(response);
                        break;
                    case 2:
                        reject(response);
                        break;
                    case 404:
                        Message.error('去404');
                        break;
                    case 500:
                        Message.error('去500');
                        break;
                    default:
                        msg && MessageBox.alert(msg);
                        break;
                }
            } else {
                resolve(response);
            }
        }, (response) => {
            let status = response.status;
            let text = response.statusText;
            switch (status) {
                case 404:
                    Message.error('去404');
                    break;
                case 500:
                    Message.error('去500');
                    break;
                default:
                    text && MessageBox.alert(text);
                    break;
            }
        });
    });
};

