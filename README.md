# pc 自动测试框架 todo list
## api 
    采用yii2 作为接口开发，尝试前后端分离
## html 
    采用vue.js 作为页面开发，学习vue.js, 为成长为全栈工程师打基础
## codeception 
    使用selenium，来做测试插件
## 使用说明
### 现在还在思考预设阶段 没的明说。反正都是我一个人玩。嘿嘿!

## do list
- 数据库设计
- 接口实现
- 页面实现
- e2e实现

以上功能部分已完成，可以使用简易的测试。
## todo list
- api 测试
- bug 统计及追踪
- 其他配置
## 安装
check git 项目，用composer将vendor 下下来。

## 项目目录
```
web
    api
        common
            config/              contains shared configurations
            mail/                contains view files for e-mails
            models/              contains model classes used in both backend and frontend
            tests/               contains tests for common classes    
        console
            config/              contains console configurations
            controllers/         contains console controllers (commands)
            migrations/          contains database migrations
            models/              contains console-specific model classes
            runtime/             contains files generated during runtime
        api
            assets/              contains application assets such as JavaScript and CSS
            config/              contains backend configurations
            controllers/         contains Web controller classes
            models/              contains backend-specific model classes
            runtime/             contains files generated during runtime
            tests/               contains tests for backend application    
            views/               contains view files for the Web application
            web/                 contains the entry script and Web resources
                tests            执行测试脚本后，生成的测试报告
        vendor/                  contains dependent 3rd-party packages
        environments/            contains environment-based overrides
    html
        build                   vue.js config
        config                  vue.js server config
        dist                    打包后生成的html代码
        src                     代码库
        static                  自己编写时使用的静态文件
```

## 使用说明
```php
1，使用命令进入后端目录(path/api), ./init 初始化项目
2，编辑文件 path/api/common/config/main-local.php， 配置数据库
3，后端目录(path/api)使用命令 ./yii migrate，初始化表
4，配置站点（省略）
5，编辑文件 path/html/src/configs/index.js  修改rootUrl 参数，此参数为站点uri
6，前端页面显示，debug模式 path/html  npm run dev 或者 直接访问  path/html/dist
7，使用命令 java -jar /path/api/tests/selenium/selenium-server-standalone-3.x.x.jar 开启selenium服务
8，后端目录(path/api)使用命令 ./yii  codecept/generate-script 生成测试文件
9，后端目录(path/api)使用命令 ./yii  codecept/web 执行ui测试
10，目前默认测试浏览器是 chrome，如果换的话，编辑文件 /path/api/tests/acceptance.suite.yml 修改 browser 参数就行
11，浏览器扩展 记得需要加入环境变量
```
## 项目中使用的扩展需要自己去下载
- ![nodeJs]( https://nodejs.org/en/)
- ![npmjs]( https://www.npmjs.com/)
- ![selenium]( http://docs.seleniumhq.org/download )
- 浏览器扩展
  - ![ChromeDriver]( https://github.com/SeleniumHQ/selenium/wiki/ChromeDriver)
  - ![Firefox]( https://github.com/mozilla/geckodriver)


