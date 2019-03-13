# 莲米粒 𑁍 LianmiLite
莲米粒是一个基于PHP+MySQL+微信小程序技术栈的、拥有用户登入、发布、修改、删除和转发信息、以及私信聊天模块的信息流应用。

![](./lianmilite.gif)

其目的有两个，首先是作为二次开发的基础项目。绝大部分应用、即使是工具类的，一旦用户变多以后，就会有添加私信和信息流系统的需求。你可以在这个系统上加上业务模块，很快的修改出一个可用的、带社会化属性的产品。

其次，用于教学和演示。目前市面上的绝大部分小程序教程，都只是找一个现成的API，主要讲解如何构建界面。莲米粒是一个同时实现了前后端的应用，不但包括了后端实现，更处理了微信用户和系统自有用户整合、自动登入等让新人棘手的流程，是一个不错的参考。希望能帮到大家。

## 安装说明

### 首先配置数据库
1. 建立一个数据库，导入 api/docs/lianmilite.sql
2. 打开 api/config/database.php , 填写数据库相关信息

### 启动API

API 需要rewrite。

#### 本地测试时：
1. cd api
2. 创建 config/hide.php，内容为
```
<?php
$GLOBALS['lpconfig']['wechat_miniapp_id'] = '小程序appid';
$GLOBALS['lpconfig']['wechat_miniapp_secret'] = '小程序appsecret';
```
3.php -S localhost:8000 route.php
注意要带 route.php 参数，不然不支持 rewrite。


#### 线上部署时
修改 api/sample.htaccess 为 .htaccess 部署于 Apache 即可。

### 启动小程序
用微信开发者工具打开 mini目录，修改appid即可。



