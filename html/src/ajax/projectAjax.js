/**
 * Created by lengbin on 2017/2/17.
 */
import Base from './base';

export default {
    projectList() {
        return Base({
            url: '/project'
        });
    },
    formValidate(body) {
        return Base({
            url: '/project/form-validate',
            body: body
        });
    },
    updateProject(body) {
        return Base({
            method: 'post',
            url: '/project/update',
            body: body
        });
    },
    deleteProject(body) {
        return Base({
            url: '/project/delete',
            body: body
        });
    }
};
