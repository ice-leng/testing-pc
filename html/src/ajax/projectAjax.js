/**
 * Created by lengbin on 2017/2/17.
 */
import Base from './base';

export default {
    projectList() {
        return Base({
            url: '/project',
            isDispose: false
        });
    },
    formValidate() {
        return Base({
            url: '/project/form-validate',
            isDispose: false
        });
    }
};
