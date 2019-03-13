<?php

namespace Lazyphp\Controller;

class LazyphpController
{
    public function __construct()
    {
    }

    /**
     * 默认提示.
     *
     * @ApiDescription(section="Demo", description="默认提示")
     * @ApiLazyRoute(uri="/",method="GET")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function index()
    {
        $weapp = new \JiaweiXS\WeApp\WeApp(c('wechat_miniapp_id'), c('wechat_miniapp_secret'), AROOT.DS.'_cache');
        $info = json_decode($weapp->getSessionKey(v('code')), 1);

        session_start();
        $_SESSION['openid'] = $info['openid'];
        $_SESSION['session_key'] = $info['session_key'];

        $data = db()->getData('SELECT '.c('user_normal_fields')." FROM `user` WHERE `openid` = '".s($info['openid'])."'")->toLine();

        $_SESSION['guid'] = $data['guid'] = $data['id'];
        $data['token'] = session_id();

        return send_result($data);
    }

    /**
     * @ApiDescription(section="User", description="用户注册")
     * @ApiLazyRoute(uri="/reg",method="GET|POST")
     * @ApiParams(name="nickname", type="string", nullable=false, description="nickname", check="check_not_empty", cnname="昵称")
     * @ApiParams(name="avatar", type="string", nullable=false, description="avatar", check="check_not_empty", cnname="头像")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function reg($nickname, $avatar)
    {
        token_login();

        if ($user = db()->getData("SELECT * FROM `user` WHERE `openid` = '".s($_SESSION['openid'])."' LIMIT 1")->toLine()) {
            return lp_throw('ARGS', '用户已经注册');
        }

        $sql = "INSERT IGNORE INTO `user` ( `openid` , `nickname` , `avatar` , `created_at` ) VALUES ( '".s($_SESSION['openid'])."' , '".s(t($nickname))."' , '".s(t($avatar))."' , '".s(lp_now())."' ) ";
        db()->runSql($sql);

        $guid = db()->lastId();

        return send_result(['guid' => $guid]);
    }

    /**
     * @ApiDescription(section="Feed", description="内容发布")
     * @ApiLazyRoute(uri="/feed/publish",method="GET|POST")
     * @ApiParams(name="content", type="string", nullable=false, description="nickname", check="check_not_empty", cnname="内容")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_publish($content)
    {
        token_login();

        $sql = "INSERT INTO `feed` ( `content` , `author_openid` , `author_uid` , `created_at` ) VALUES ( '".s($content)."' , '".s($_SESSION['openid'])."' , '".s($_SESSION['guid'])."' , '".s(lp_now())."' ) ";
        db()->runSql($sql);

        $feedid = db()->lastId();

        return send_result(['id' => $feedid]);
    }

    /**
     * @ApiDescription(section="Feed", description="内容删除")
     * @ApiLazyRoute(uri="/feed/remove",method="GET|POST")
     * @ApiParams(name="id", type="string", nullable=false, description="id", check="check_not_zero", cnname="id")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_remove($id)
    {
        token_login();

        if (!$feed = table('feed')->getAllById($id)->toLine()) {
            lp_throw('ARGS', '错误的feed id');
        }

        if ($feed['rt_id'] > 0) {
            if ($feed['rt_uid'] != $_SESSION['guid']) {
                lp_throw('AUTH', '只能更新自己的转发');
            }
        } else {
            if ($feed['author_uid'] != $_SESSION['guid']) {
                lp_throw('AUTH', '只能更新自己的feed');
            }
        }

        $sql = "DELETE FROM `feed` WHERE `id` = '".intval($id)."' LIMIT 1";

        db()->runSql($sql);

        return send_result($feed);
    }

    /**
     * @ApiDescription(section="Feed", description="内容展示")
     * @ApiLazyRoute(uri="/feed/detail",method="GET|POST")
     * @ApiParams(name="id", type="string", nullable=false, description="id", check="check_not_zero", cnname="id")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_detail($id)
    {
        // token_login();

        if (!$feed = db()->getData("SELECT * , `author_uid` as `user` , `rt_uid` as `rt_user` FROM `feed`  WHERE `id` = '".intval($id)."' LIMIT 1")->toLine()) {
            lp_throw('ARGS', '错误的feed id');
        }

        if ($feed['rt_id'] > 0) {
            $origin = db()->getData("SELECT * FROM `feed` WHERE `id` = '".intval($feed['rt_id'])."' LIMIT 1 ")->toLine();

            $feed['user'] = $feed['author_uid'] = $origin['author_uid'];
            $feed['author_openid'] = $origin['author_openid'];
            $feed['content'] = $origin['content'];
            $feed['created_at'] = $origin['created_at'];
        }

        $feed = extend_field_oneline($feed, 'user', 'user');
        $feed = extend_field_oneline($feed, 'rt_user', 'user');

        return send_result($feed);
    }

    /**
     * @ApiDescription(section="Feed", description="内容更新")
     * @ApiLazyRoute(uri="/feed/rt",method="GET|POST")
     * @ApiParams(name="id", type="string", nullable=false, description="id", check="check_not_zero", cnname="id")
     * @ApiParams(name="content", type="string", nullable=false, description="content", cnname="content")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_rt($id, $content = '')
    {
        token_login();

        if (!$feed = table('feed')->getAllById($id)->toLine()) {
            lp_throw('ARGS', '错误的feed id');
        }

        $sql = "INSERT INTO `feed` ( `rt_id` , `rt_content` , `rt_openid` , `rt_uid` , `rt_at` ) VALUES ( '".intval($id)."' , '".s($content)."' , '".s($_SESSION['openid'])."' , '".s($_SESSION['guid'])."' , '".s(lp_now())."' ) ";

        db()->runSql($sql);

        $feedid = db()->lastId();

        return send_result(['id' => $feedid]);
    }

    /**
     * @ApiDescription(section="Feed", description="内容更新")
     * @ApiLazyRoute(uri="/feed/update",method="GET|POST")
     * @ApiParams(name="id", type="string", nullable=false, description="id", check="check_not_zero", cnname="id")
     * @ApiParams(name="content", type="string", nullable=false, description="content", check="check_not_empty", cnname="content")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_update($id, $content)
    {
        token_login();

        if (!$feed = table('feed')->getAllById($id)->toLine()) {
            lp_throw('ARGS', '错误的feed id');
        }

        if ($feed['rt_id'] > 0) {
            if ($feed['rt_uid'] != $_SESSION['guid']) {
                lp_throw('AUTH', '只能更新自己的转发');
            }

            $sql = "UPDATE `feed` SET `rt_content` = '".s($content)."' WHERE `id` = '".intval($id)."' LIMIT 1";
        } else {
            if ($feed['author_uid'] != $_SESSION['guid']) {
                lp_throw('AUTH', '只能更新自己的feed');
            }

            $sql = "UPDATE `feed` SET `content` = '".s($content)."' WHERE `id` = '".intval($id)."' LIMIT 1";
        }

        db()->runSql($sql);

        $feed['content'] = $content;

        return send_result($feed);
    }

    /**
     * @ApiDescription(section="Feed", description="信息流列表")
     * @ApiLazyRoute(uri="/feed/list",method="GET")
     * @ApiParams(name="since", type="id", nullable=false, description="nickname", check="intval", cnname="sinceid")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_list($since = 0)
    {
        // token_login();
        $limit = c('list_item_per_page');
        if ($since == 0) {
            $sql = "SELECT * , `author_uid` as `user` , `rt_uid` as `rt_user`  FROM `feed`  ORDER BY `id` DESC LIMIT $limit ";
        } else {
            $sql = "SELECT * , `author_uid` as `user` , `rt_uid` as `rt_user` FROM `feed` WHERE `id` < $since ORDER BY `id` DESC LIMIT $limit ";
        }

        if ($feeds = db()->getData($sql)->toArray()) {
            $feeds = feed_complete($feeds);
            $feeds = extend_field($feeds, 'user', 'user');
            $feeds = extend_field($feeds, 'rt_user', 'user');
        }

        return send_result($feeds);
    }

    /**
     * @ApiDescription(section="Feed", description="某个用户的信息流列表")
     * @ApiLazyRoute(uri="/feed/uid/@uid",method="GET")
     * @ApiParams(name="since", type="id", nullable=false, description="since", check="intval", cnname="sinceid")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_uid($uid, $since = 0)
    {
        $limit = c('list_item_per_page');
        if ($since == 0) {
            $sql = "SELECT * , `author_uid` as `user` , `rt_uid` as `rt_user`  FROM `feed` WHERE `author_uid` = '".intval($uid)."' OR `rt_uid` = '".intval($uid)."'  ORDER BY `id` DESC LIMIT $limit ";
        } else {
            $sql = "SELECT * , `author_uid` as `user` , `rt_uid` as `rt_user` FROM `feed` WHERE `id` < $since AND ( `author_uid` = '".intval($uid)."' OR `rt_uid` = '".intval($uid)."'  ) ORDER BY `id` DESC LIMIT $limit ";
        }

        if ($feeds = db()->getData($sql)->toArray()) {
            $feeds = feed_complete($feeds);
            $feeds = extend_field($feeds, 'user', 'user');
            $feeds = extend_field($feeds, 'rt_user', 'user');
        }

        return send_result($feeds);
    }

    /**
     * @ApiDescription(section="user", description="内容展示")
     * @ApiLazyRoute(uri="/user/detail",method="GET|POST")
     * @ApiParams(name="id", type="string", nullable=false, description="id", check="check_not_zero", cnname="id")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function user_detail($id)
    {
        try {
            token_login();
        } catch (\Exception $e) {
        }

        if (!$user = db()->getData('SELECT '.c('user_normal_fields')." FROM `user`  WHERE `id` = '".intval($id)."' LIMIT 1")->toLine()) {
            lp_throw('ARGS', '错误的user id');
        }

        // 如果是登入状态
        if ($_SESSION['guid'] > 0) {
            $user['followed'] = db()->getData("SELECT COUNT(*) FROM `follow` WHERE `fans_uid` = '".intval($_SESSION['guid'])."' AND `uid` = '".intval($id)."'")->toVar();
        }

        return send_result($user);
    }

    /**
     * @ApiDescription(section="user", description="内容展示")
     * @ApiLazyRoute(uri="/user/follow",method="GET|POST")
     * @ApiParams(name="uid", type="string", nullable=false, description="uid", check="check_not_zero", cnname="uid")
     * @ApiParams(name="status", type="string", nullable=false, description="status",  cnname="status")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function user_follow($uid, $status = 0)
    {
        token_login();

        if (!$user = db()->getData('SELECT '.c('user_normal_fields')." FROM `user`  WHERE `id` = '".intval($uid)."' LIMIT 1")->toLine()) {
            lp_throw('ARGS', '错误的user id');
        }

        if ($user['id'] == $_SESSION['guid']) {
            return lp_throw('ARGS', '不能关注和取关自己');
        }

        if ($status == 1) {
            // 关注
            $sql = "INSERT IGNORE `follow` ( `uid` , `fans_uid` ) VALUES ( '".intval($uid)."' , '".intval($_SESSION['guid'])."' )";
        } else {
            $status = 0;
            $sql = "DELETE FROM `follow` WHERE `fans_uid` = '".intval($_SESSION['guid'])."' AND `uid` = '".intval($uid)."' LIMIT 1";
        }

        db()->runSql($sql);

        // 调整uid的粉丝数量
        $fans_count = recount_fans($uid);

        // 调整当前用户的关注数据量
        $follow_count = recount_follow($_SESSION['guid']);

        $user['fans_count'] = $fans_count;
        $user['followed'] = $status;

        return send_result($user);
    }

    /**
     * 向某用户发送私信
     *
     * @ApiDescription(section="Message", description="向某用户发送私信")
     * @ApiLazyRoute(uri="/message/send",method="GET|POST")
     * @ApiParams(name="to_uid", type="int", nullable=false, description="to_uid", check="check_not_zero", cnname="用户ID")
     * @ApiParams(name="text", type="string", nullable=false, description="text", check="check_not_empty", cnname="私信内容")

     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function message_send($to_uid, $text)
    {
        token_login();

        if ($to_uid == $_SESSION['guid']) {
            return lp_throw('ARGS', '不要自己给自己发私信啦');
        }

        $now = lp_now();

        // 发信人的记录。标记为已读
        $sql = "INSERT INTO `message` ( `uid` , `to_uid` , `from_uid` , `text` , `created_at` , `is_read` ) VALUES ( '".intval($_SESSION['guid'])."' , '".intval($to_uid)."' , '".intval($_SESSION['guid'])."' , '".s($text)."' , '".s($now)."' , '1' )";
        db()->runSql($sql);

        // 收信人的记录。标记为未读
        $sql = "INSERT INTO `message` ( `uid` , `to_uid` , `from_uid` , `text` , `created_at` , `is_read` ) VALUES ( '".intval($to_uid)."' , '".intval($to_uid)."' , '".intval($_SESSION['guid'])."' , '".s($text)."' , '".s($now)."' , '0' )";
        db()->runSql($sql);

        $last_mid = db()->lastId();

        // 对话组的冗余记录，用于按分组显示对话

        // 删除原有记录
        $sql = "DELETE FROM `message_group` WHERE ( `to_uid` = '".intval($to_uid)."' AND `from_uid` = '".intval($_SESSION['guid'])."' ) OR ( `to_uid` = '".intval($_SESSION['guid'])."' AND `from_uid` = '".intval($to_uid)."' ) LIMIT 2";
        db()->runSql($sql);

        $sql = "INSERT IGNORE INTO `message_group` ( `uid` , `to_uid` , `from_uid` , `text` , `created_at` , `is_read` ) VALUES ( '".intval($_SESSION['guid'])."' , '".intval($to_uid)."' , '".intval($_SESSION['guid'])."' , '".s($text)."' , '".s($now)."' , '1' )";
        db()->runSql($sql);

        $sql = "INSERT IGNORE INTO `message_group` ( `uid` , `to_uid` , `from_uid` , `text` , `created_at` , `is_read` ) VALUES ( '".intval($to_uid)."' , '".intval($to_uid)."' , '".intval($_SESSION['guid'])."' , '".s($text)."' , '".s($now)."' , '0' )";

        db()->runSql($sql);

        return send_result('done');
    }

    /**
     * 获得和某个用户的聊天记录最新id.
     *
     * @ApiDescription(section="Message", description="获得和某个用户的聊天记录最新id")
     * @ApiLazyRoute(uri="/message/lastid",method="GET|POST")
     * @ApiParams(name="to_uid", type="int", nullable=false, description="to_uid", check="check_uint", cnname="用户ID")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function message_lastid($to_uid)
    {
        token_login();

        return send_result(intval(db()->getData("SELECT MAX(`id`) FROM `message` WHERE `uid` = '".intval($_SESSION['guid'])."' AND ( `to_uid` = '".intval($to_uid)."' OR `from_uid` = '".intval($to_uid)."'  ) ")->toVar()));
    }

    /**
     * 获得当前用户未读信息数量.
     *
     * @ApiDescription(section="Message", description="获得当前用户未读信息数量")
     * @ApiLazyRoute(uri="/message/unread",method="GET|POST")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function get_message_unread_count()
    {
        token_login();

        return send_result(intval(db()->getData("SELECT COUNT(*) FROM `message` WHERE `uid` = '".intval($_SESSION['guid'])."' AND `is_read` = 0 ")->toVar()));
    }

    /**
     * 获得当前用户的最新消息分组列表页面.
     *
     * @ApiDescription(section="Message", description="获得当前用户的最新消息分组列表页面")
     * @ApiLazyRoute(uri="/message/grouplist",method="GET|POST")
     * @ApiParams(name="since_id", type="int", nullable=false, description="since_id", cnname="游标ID")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function message_group_list($since_id = 0)
    {
        token_login();

        $limit = c('list_item_per_page');
        $since_sql = $since_id == 0 ? '' : " AND `id` < '".intval($since_id)."' ";

        $sql = "SELECT * , `from_uid` as `from_user` , `to_uid` as `to_user` FROM `message_group` WHERE `uid` = '".intval($_SESSION['guid'])."'  ".$since_sql.' ORDER BY `id` DESC  LIMIT '.$limit;

        $data = db()->getData($sql)->toArray();
        $data = extend_field($data, 'from_user', 'user');
        $data = extend_field($data, 'to_user', 'user');

        return send_result($data);
    }

    /**
     * 获得和某个用户的聊天记录（更旧）.
     *
     * @ApiDescription(section="Message", description="获得和某个用户的聊天记录")
     * @ApiLazyRoute(uri="/message/old",method="GET|POST")
     * @ApiParams(name="to_uid", type="int", nullable=false, description="to_uid", check="check_uint", cnname="用户ID")
     * @ApiParams(name="since_id", type="int", nullable=false, description="since_id", cnname="游标ID")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function message_old($to_uid, $since_id = 0)
    {
        return $this->message_list($to_uid, $since_id, true);
    }

    /**
     * 获得和某个用户的聊天记录（更新）.
     *
     * @ApiDescription(section="Message", description="获得和某个用户的聊天记录")
     * @ApiLazyRoute(uri="/message/new",method="GET|POST")
     * @ApiParams(name="to_uid", type="int", nullable=false, description="to_uid", check="check_uint", cnname="用户ID")
     * @ApiParams(name="since_id", type="int", nullable=false, description="since_id", cnname="游标ID")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function message_new($to_uid, $since_id = 0)
    {
        return $this->message_list($to_uid, $since_id, false);
    }

    private function message_list($to_uid, $since_id = 0, $old = true)
    {
        token_login();
        $limit = c('list_item_per_page');

        if ($since_id == 0) {
            if ($old) {
                $since_sql = ' ORDER BY `id` DESC  LIMIT '.$limit;
            } else {
                $since_sql = ' ORDER BY `id` DESC  LIMIT '.$limit;
            }
        } else {
            if ($old) {
                $since_sql = "AND `id` < '".intval($since_id)."' ORDER BY `id` DESC  LIMIT ".$limit;
            } else {
                $since_sql = "AND `id` > '".intval($since_id)."'  ORDER BY `id` ASC  LIMIT ".$limit;
            }
        }

        $sql = "SELECT * , `to_uid` as `to_user` , `from_uid` as `from_user` FROM `message` WHERE `uid` = '".intval($_SESSION['guid'])."' AND ( `to_uid` = '".intval($to_uid)."' OR `from_uid` = '".intval($to_uid)."'  ) ".$since_sql;

        //return send_result( $sql );

        $data = db()->getData($sql)->toArray();

        if (is_array($data) && count($data) > 0) {
            // 如果是取新数据
            // 将 message 和 message_group 对应的内容标记为已读
            if (!$old) {
                db()->runSql("UPDATE `message` SET `is_read` = 1 WHERE  `is_read` = 0 AND `uid` = '".intval($_SESSION['guid'])."' AND ( `to_uid` = '".intval($to_uid)."' OR `from_uid` = '".intval($to_uid)."'  ) ");

                db()->runSql("UPDATE `message_group` SET `is_read` = 1 WHERE `is_read` = 0 AND `uid` = '".intval($_SESSION['guid'])."' AND ( `to_uid` = '".intval($to_uid)."' OR `from_uid` = '".intval($to_uid)."'  ) ");
            }
        }

        $data = extend_field($data, 'to_user', 'user');
        $data = extend_field($data, 'from_user', 'user');

        if ($since_id == 0 && !$old) {
            $data = array_reverse($data);
        }

        return send_result($data);
    }

    /**
     * @ApiDescription(section="Feed", description="信息流列表")
     * @ApiLazyRoute(uri="/feed/mylist",method="GET")
     * @ApiParams(name="since", type="id", nullable=false, description="nickname", check="intval", cnname="sinceid")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function feed_mylist($since = 0)
    {
        token_login();
        $limit = c('list_item_per_page');

        $where_sql[] = $since > 0 ? " `id` < $since " : ' 1 ';

        $where_sql[] = " ( `author_uid` IN ( SELECT `uid` FROM `follow` WHERE `fans_uid` = '".intval($_SESSION['guid'])."' ) OR `rt_uid` IN ( SELECT `uid` FROM `follow` WHERE `fans_uid` = '".intval($_SESSION['guid'])."' ) ) ";

        $sql = 'SELECT * , `author_uid` as `user` , `rt_uid` as `rt_user` FROM `feed` WHERE '.join(' AND ', $where_sql)." ORDER BY `id` DESC LIMIT $limit ";

        if ($feeds = db()->getData($sql)->toArray()) {
            $feeds = feed_complete($feeds);
            $feeds = extend_field($feeds, 'user', 'user');
            $feeds = extend_field($feeds, 'rt_user', 'user');
        }

        return send_result($feeds);
    }

    /**
     * 系统提示.
     *
     * @ApiDescription(section="Demo", description="系统提示")
     * @ApiLazyRoute(uri="/info",method="GET")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function info()
    {
        token_login();

        return send_result($_SESSION);
    }

    /**
     * Demo接口.
     *
     * @ApiDescription(section="Demo", description="乘法接口")
     * @ApiLazyRoute(uri="/demo/times",method="GET")
     * @ApiParams(name="first", type="string", nullable=false, description="first", check="check_not_empty", cnname="第一个数")
     * @ApiParams(name="second", type="string", nullable=false, description="second", check="check_not_empty", cnname="第二个数")
     * @ApiReturn(type="object", sample="{'code': 0,'message': 'success'}")
     */
    public function demo($first, $second)
    {
        return send_result(intval($first) * intval($second));
    }
}
