<?php 
namespace Lazyphp\Core {
Class RestException extends \Exception {}
Class RouteException extends \Lazyphp\Core\RestException {}
Class InputException extends \Lazyphp\Core\RestException {}
Class DatabaseException extends \Lazyphp\Core\RestException {}
Class DataException extends \Lazyphp\Core\RestException {}
Class AuthException extends \Lazyphp\Core\RestException {}
}
namespace{
$GLOBALS['meta'] = array (
  '70c907e8750f400eb470132e210b44cb' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Demo',
        'description' => '默认提示',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET /',
        'ApiMethod' => '(type="GET")',
        'ApiRoute' => '(name="/")',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => false,
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET /',
        'params' => false,
      ),
    ),
  ),
  '6a723d8b656f2e2e3320afc14aed61ae' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'User',
        'description' => '用户注册',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /reg',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/reg")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'nickname',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => '昵称',
      ),
      1 => 
      array (
        'name' => 'avatar',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => '头像',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'nickname' => 
      array (
        'name' => 'nickname',
      ),
      'avatar' => 
      array (
        'name' => 'avatar',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /reg',
        'params' => false,
      ),
    ),
  ),
  '58081745e241bc2d0124a19ee6d11574' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '内容发布',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /feed/publish',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/feed/publish")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'content',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => '内容',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'content' => 
      array (
        'name' => 'content',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /feed/publish',
        'params' => false,
      ),
    ),
  ),
  '5d7d61ab3f81749a4e7fd82ed761fca8' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '内容删除',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /feed/remove',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/feed/remove")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'id',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => 'id',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'id' => 
      array (
        'name' => 'id',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /feed/remove',
        'params' => false,
      ),
    ),
  ),
  '8ec410a088472a2c77eefd09a3a88bd7' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '内容展示',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /feed/detail',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/feed/detail")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'id',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => 'id',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'id' => 
      array (
        'name' => 'id',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /feed/detail',
        'params' => false,
      ),
    ),
  ),
  'b1c7338d2a7d14a06c97145fb9d78a75' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '内容更新',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /feed/rt',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/feed/rt")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'id',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => 'id',
      ),
      1 => 
      array (
        'name' => 'content',
        'filters' => 
        array (
          0 => 'donothing',
        ),
        'cnname' => 'content',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'id' => 
      array (
        'name' => 'id',
      ),
      'content' => 
      array (
        'name' => 'content',
        'default' => '',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /feed/rt',
        'params' => false,
      ),
    ),
  ),
  '48d8561dbf9fa0880b17c5b09271b5cf' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '内容更新',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /feed/update',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/feed/update")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'id',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => 'id',
      ),
      1 => 
      array (
        'name' => 'content',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => 'content',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'id' => 
      array (
        'name' => 'id',
      ),
      'content' => 
      array (
        'name' => 'content',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /feed/update',
        'params' => false,
      ),
    ),
  ),
  '83b8fee66f4acfafc99c2a7e78b50cc2' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '信息流列表',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET /feed/list',
        'ApiMethod' => '(type="GET")',
        'ApiRoute' => '(name="/feed/list")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'since',
        'filters' => 
        array (
          0 => 'intval',
        ),
        'cnname' => 'sinceid',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'since' => 
      array (
        'name' => 'since',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET /feed/list',
        'params' => false,
      ),
    ),
  ),
  'bac444aca3dbff13aaa96eb8636f0965' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '某个用户的信息流列表',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET /feed/uid/@uid',
        'ApiMethod' => '(type="GET")',
        'ApiRoute' => '(name="/feed/uid/{uid}")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'since',
        'filters' => 
        array (
          0 => 'intval',
        ),
        'cnname' => 'sinceid',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'uid' => 
      array (
        'name' => 'uid',
      ),
      'since' => 
      array (
        'name' => 'since',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET /feed/uid/@uid',
        'params' => 
        array (
          0 => 'uid',
        ),
      ),
    ),
  ),
  'f11c486a3b043b33bc729b9458a44d0a' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'user',
        'description' => '内容展示',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /user/detail',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/user/detail")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'id',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => 'id',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'id' => 
      array (
        'name' => 'id',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /user/detail',
        'params' => false,
      ),
    ),
  ),
  '997d92e8a9e8837a76e029680bb46975' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'user',
        'description' => '内容展示',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /user/follow',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/user/follow")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'uid',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => 'uid',
      ),
      1 => 
      array (
        'name' => 'status',
        'filters' => 
        array (
          0 => 'donothing',
        ),
        'cnname' => 'status',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'uid' => 
      array (
        'name' => 'uid',
      ),
      'status' => 
      array (
        'name' => 'status',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /user/follow',
        'params' => false,
      ),
    ),
  ),
  'e7242d0bade8d0feaf7957511bef6fc7' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Message',
        'description' => '向某用户发送私信',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /message/send',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/message/send")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'to_uid',
        'filters' => 
        array (
          0 => 'check_not_zero',
        ),
        'cnname' => '用户ID',
      ),
      1 => 
      array (
        'name' => 'text',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => '私信内容',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'to_uid' => 
      array (
        'name' => 'to_uid',
      ),
      'text' => 
      array (
        'name' => 'text',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /message/send',
        'params' => false,
      ),
    ),
  ),
  '142c0cd5b837d675a796c6e98850e456' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Message',
        'description' => '获得和某个用户的聊天记录最新id',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /message/lastid',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/message/lastid")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'to_uid',
        'filters' => 
        array (
          0 => 'check_uint',
        ),
        'cnname' => '用户ID',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'to_uid' => 
      array (
        'name' => 'to_uid',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /message/lastid',
        'params' => false,
      ),
    ),
  ),
  '0fe93217f34e38308efb57d84587a1ed' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Message',
        'description' => '获得当前用户未读信息数量',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /message/unread',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/message/unread")',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => false,
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /message/unread',
        'params' => false,
      ),
    ),
  ),
  '66e692329822003a2fadbbfb1dd27361' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Message',
        'description' => '获得当前用户的最新消息分组列表页面',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /message/grouplist',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/message/grouplist")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'since_id',
        'filters' => 
        array (
          0 => 'donothing',
        ),
        'cnname' => '游标ID',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'since_id' => 
      array (
        'name' => 'since_id',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /message/grouplist',
        'params' => false,
      ),
    ),
  ),
  '684840ddf86eb2314cfcacbda7561c65' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Message',
        'description' => '获得和某个用户的聊天记录',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /message/old',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/message/old")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'to_uid',
        'filters' => 
        array (
          0 => 'check_uint',
        ),
        'cnname' => '用户ID',
      ),
      1 => 
      array (
        'name' => 'since_id',
        'filters' => 
        array (
          0 => 'donothing',
        ),
        'cnname' => '游标ID',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'to_uid' => 
      array (
        'name' => 'to_uid',
      ),
      'since_id' => 
      array (
        'name' => 'since_id',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /message/old',
        'params' => false,
      ),
    ),
  ),
  '0ef552ac073bacad6d4c2cabde5c3b3c' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Message',
        'description' => '获得和某个用户的聊天记录',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET|POST /message/new',
        'ApiMethod' => '(type="GET|POST")',
        'ApiRoute' => '(name="/message/new")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'to_uid',
        'filters' => 
        array (
          0 => 'check_uint',
        ),
        'cnname' => '用户ID',
      ),
      1 => 
      array (
        'name' => 'since_id',
        'filters' => 
        array (
          0 => 'donothing',
        ),
        'cnname' => '游标ID',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'to_uid' => 
      array (
        'name' => 'to_uid',
      ),
      'since_id' => 
      array (
        'name' => 'since_id',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET|POST /message/new',
        'params' => false,
      ),
    ),
  ),
  '72736f0ad6f8a8219bfd173c83d0a550' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Feed',
        'description' => '信息流列表',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET /feed/mylist',
        'ApiMethod' => '(type="GET")',
        'ApiRoute' => '(name="/feed/mylist")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'since',
        'filters' => 
        array (
          0 => 'intval',
        ),
        'cnname' => 'sinceid',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'since' => 
      array (
        'name' => 'since',
        'default' => 0,
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET /feed/mylist',
        'params' => false,
      ),
    ),
  ),
  '039a3032e1bca4289db765365162086a' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Demo',
        'description' => '系统提示',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET /info',
        'ApiMethod' => '(type="GET")',
        'ApiRoute' => '(name="/info")',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => false,
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET /info',
        'params' => false,
      ),
    ),
  ),
  'eb12852dde30c86f2681120ef5001954' => 
  array (
    'Description' => 
    array (
      0 => 
      array (
        'section' => 'Demo',
        'description' => '乘法接口',
      ),
    ),
    'LazyRoute' => 
    array (
      0 => 
      array (
        'route' => 'GET /demo/times',
        'ApiMethod' => '(type="GET")',
        'ApiRoute' => '(name="/demo/times")',
      ),
    ),
    'Params' => 
    array (
      0 => 
      array (
        'name' => 'first',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => '第一个数',
      ),
      1 => 
      array (
        'name' => 'second',
        'filters' => 
        array (
          0 => 'check_not_empty',
        ),
        'cnname' => '第二个数',
      ),
    ),
    'Return' => 
    array (
      0 => 
      array (
        'type' => 'object',
        'sample' => '{\'code\': 0,\'message\': \'success\'}',
      ),
    ),
    'binding' => 
    array (
      'first' => 
      array (
        'name' => 'first',
      ),
      'second' => 
      array (
        'name' => 'second',
      ),
    ),
    'route' => 
    array (
      0 => 
      array (
        'uri' => 'GET /demo/times',
        'params' => false,
      ),
    ),
  ),
);
$app = new \Lazyphp\Core\Application();
$app->route('GET /',array( 'Lazyphp\Controller\LazyphpController','index'));
$app->route('GET|POST /reg',array( 'Lazyphp\Controller\LazyphpController','reg'));
$app->route('GET|POST /feed/publish',array( 'Lazyphp\Controller\LazyphpController','feed_publish'));
$app->route('GET|POST /feed/remove',array( 'Lazyphp\Controller\LazyphpController','feed_remove'));
$app->route('GET|POST /feed/detail',array( 'Lazyphp\Controller\LazyphpController','feed_detail'));
$app->route('GET|POST /feed/rt',array( 'Lazyphp\Controller\LazyphpController','feed_rt'));
$app->route('GET|POST /feed/update',array( 'Lazyphp\Controller\LazyphpController','feed_update'));
$app->route('GET /feed/list',array( 'Lazyphp\Controller\LazyphpController','feed_list'));
$app->route('GET /feed/uid/@uid',array( 'Lazyphp\Controller\LazyphpController','feed_uid'));
$app->route('GET|POST /user/detail',array( 'Lazyphp\Controller\LazyphpController','user_detail'));
$app->route('GET|POST /user/follow',array( 'Lazyphp\Controller\LazyphpController','user_follow'));
$app->route('GET|POST /message/send',array( 'Lazyphp\Controller\LazyphpController','message_send'));
$app->route('GET|POST /message/lastid',array( 'Lazyphp\Controller\LazyphpController','message_lastid'));
$app->route('GET|POST /message/unread',array( 'Lazyphp\Controller\LazyphpController','get_message_unread_count'));
$app->route('GET|POST /message/grouplist',array( 'Lazyphp\Controller\LazyphpController','message_group_list'));
$app->route('GET|POST /message/old',array( 'Lazyphp\Controller\LazyphpController','message_old'));
$app->route('GET|POST /message/new',array( 'Lazyphp\Controller\LazyphpController','message_new'));
$app->route('GET /feed/mylist',array( 'Lazyphp\Controller\LazyphpController','feed_mylist'));
$app->route('GET /info',array( 'Lazyphp\Controller\LazyphpController','info'));
$app->route('GET /demo/times',array( 'Lazyphp\Controller\LazyphpController','demo'));
$app->run();
}
