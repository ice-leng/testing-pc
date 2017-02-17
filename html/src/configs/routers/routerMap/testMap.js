/**
 * Created by lengbin on 2017/2/16.
 */

export default [{
    path: '/test/item',
    key: 'test-item',
    text: '测试项',
    component: resolve => {
        require(['views/test/item'], resolve);
    }
}, {
    path: '/test/item2',
    key: 'test-item2',
    text: '测试项2',
    component: resolve => {
        require(['views/test/item'], resolve);
    }
}];
