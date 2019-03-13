<?php
@include_once __DIR__ . DS . 'hide.php';

$GLOBALS['lpconfig']['site_name'] = 'LianmiLite';
$GLOBALS['lpconfig']['site_domain'] = '';

$GLOBALS['lpconfig']['user_normal_fields'] = ' `id` , `openid` , `nickname` , `avatar` , `created_at` , `follow_count` , `fans_count` ';

$GLOBALS['lpconfig']['list_item_per_page'] = 100;




$GLOBALS['lpconfig']['mode'] = 'dev';

if(!on_sae())
	$GLOBALS['lpconfig']['buildeverytime'] = true;


