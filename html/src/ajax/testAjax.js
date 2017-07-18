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
    testWorkflowName(body) {
        return Base({
            url: '/test/test-workflow-name',
            body: body
        });
    }
};
