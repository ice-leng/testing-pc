/**
 * Created by lengbin on 2017/2/16.
 */

export default [{
    path: '/test',
    key: 'test-index',
    text: '测试流程',
    component: resolve => {
        require(['views/test/index'], resolve);
    }
}, {
    path: '/test/log',
    key: 'test-log',
    text: '测试日志',
    component: resolve => {
        require(['views/test/item'], resolve);
    }
}, {
    path: '/test/bug',
    key: 'test-bug',
    text: 'bug统计',
    component: resolve => {
        require(['views/test/bug'], resolve);
    }
}];
