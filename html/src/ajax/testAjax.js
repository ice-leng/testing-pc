/**
 * Created by lengbin on 2017/7/12.
 */

import Base from './base.js';

export default {
    testWorkflowFormValidate(body) {
        return Base({
            url: '/test/form-validate',
            body: body
        });
    },
    testWorkflowList(body) {
        return Base({
            url: '/test',
            body: body,
            method: 'get'
        });
    },
    testItemName(body) {
        return Base({
            url: '/test/test-item-name',
            body: body
        });
    },
    testWorkflowUpdate(body) {
        return Base({
            url: '/test/update',
            body: body,
            method: 'post'
        });
    },
    testWorkflowDelete(body) {
        return Base({
            url: '/test/delete-workflow',
            body: body,
            method: 'get'
        });
    },
    generateCase(body) {
        return Base({
            url: '/test/generate-case',
            body: body,
            method: 'get'
        });
    },
    changeRunStatus(body) {
        return Base({
            url: '/test/run',
            body: body,
            method: 'get'
        });
    }
};
