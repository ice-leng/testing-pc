/**
 * Created by lengbin on 2017/2/15.
 */

export default [{
    path: '/project',
    key: 'project',
    text: '项目',
    component: resolve => {
        require(['views/project/index'], resolve);
    }
}, {
    path: '/config',
    key: 'config',
    text: '配置',
    component: resolve => {
        require(['views/config/index'], resolve);
    }
}];
