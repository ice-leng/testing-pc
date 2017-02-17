/**
 * Created by lengbin on 2017/2/15.
 */
import projectMap from './projectMap';
import testMap from './testMap';

const routers = [{
    path: '/',
    key: 'project',
    text: '项目',
    name: 'project',
    children: projectMap,
    redirect: '/project',
    component: resolve => {
        require(['views/layout/main'], resolve);
    }
}, {
    path: '/test',
    key: 'test',
    text: '测试',
    name: 'test',
    component: resolve => {
        require(['views/layout/main'], resolve);
    },
    children: testMap
}];

export default routers;

