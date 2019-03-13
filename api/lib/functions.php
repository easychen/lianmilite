<?php
function token_login()
{
    if(strlen(v('token'))>0)
    {
        session_id(v('token'));
        session_start();
        if( !isset( $_SESSION['openid'] ) || strlen( $_SESSION['openid'] ) < 1 )
        lp_throw( 'AUTH' , '错误的token' );
    }
    else
    {
        lp_throw( 'ARGS' , 'token不能为空' );   
    }    
}

function table( $name )
{
    if( !isset( $GLOBALS['LP_LDO_'.$name] ) )
    {
        $GLOBALS['LP_LDO_'.$name] = new \Lazyphp\Core\Ldo($name);
    }

    return $GLOBALS['LP_LDO_'.$name];
}

function lp_throw( $type , $info , $args = null )
{
    if( !is_array( $args )) $args = [ $args ] ;
    $code = isset( c('error_type')[$type] ) ? c('error_type')[$type] : 99999;
    $message = '[' . $type . ']' . sprintf( $info , ...$args );
    throw new \Lazyphp\Core\LpException( $message , $code , $info , $args );
}

function lp_now()
{
    return date("Y-m-d H:i:s");
}

function lp_uid()
{
    return isset( $_SESSION['uid'] ) ? intval( $_SESSION['uid'] ) : 0;
}

function recount_fans( $uid )
{
    $sql = "SELECT COUNT(*) FROM `follow` WHERE `uid` = '" . intval( $uid ) . "'";
    $fans_count = db()->getData( $sql )->toVar();
    $sql = "UPDATE `user` SET `fans_count` = '" . intval($fans_count) . "' WHERE `id` = '" . intval( $uid ) . "' LIMIT 1  ";
    db()->runSql( $sql );

    return $fans_count;
}

function recount_follow( $uid )
{
    $sql = "SELECT COUNT(*) FROM `follow` WHERE `fans_uid` = '" . intval( $uid ) . "'";
    $follow_count = db()->getData( $sql )->toVar();
    $sql = "UPDATE `user` SET `follow_count` = '" . $follow_count . "' WHERE `id` = '" . intval( $uid ) . "' LIMIT 1 ";
    db()->runSql( $sql );

    return $follow_count;
}

function feed_complete( $feeds )
{
    foreach( $feeds as $item )
    {
        if( $item['rt_id'] > 0 )
        $rt_ids[] = $item['rt_id'];
    }

    if( isset( $rt_ids ) )
    {
        $origins = db()->getData( "SELECT * FROM `feed` WHERE `id` IN ( " . join( "," , $rt_ids ) . ") " )->toIndexedArray('id');
    }

    if( isset( $origins ) )
    {
        foreach( $feeds as $key => $item )
        {
            // 补全转发记录中的原发内容
            if( $item['rt_id'] > 0 && isset( $origins[$item['rt_id']] )  )
            {
                $ORG = $origins[$item['rt_id']];
                $feeds[$key]['user'] = $feeds[$key]['author_uid'] = $ORG['author_uid'];
                $feeds[$key]['author_openid'] = $ORG['author_openid'];
                $feeds[$key]['content'] = $ORG['content'];
                $feeds[$key]['created_at'] = $ORG['created_at'];
            }
        }
    }
    return $feeds;
}

// **************************** extend lib ******************
function extend_field( $array , $field , $table , $join = 'id' )
{
    if( !is_array( $array ) ) return $array;
    $ids = array_map(  function( $item ) use ( $field ) {  return "'" . $item[$field] . "'";  }  , $array );

    $ids = array_unique( $ids );

    if( $table == 'user' )
        $sql = "SELECT " . c('user_normal_fields') . " FROM `" . s( $table ) . "` WHERE `" . s( $join ) . "` IN ( " . join( ',' , $ids ) . " )";
    elseif(  $table == 'section' )
        $sql = "SELECT `id` , `title` , `chapter_id` FROM `" . s( $table ) . "` WHERE `" . s( $join ) . "` IN ( " . join( ',' , $ids ) . " )";
    else
        $sql = "SELECT * FROM `" . s( $table ) . "` WHERE `" . s( $join ) . "` IN ( " . join( ',' , $ids ) . " )";
    
    if( $data = db()->getData( $sql )->toIndexedArray( $join ))
    {
        foreach( $array as $key => $item )
        {
            if( isset( $data[$item[$field]] ) )
                $array[$key][$field] = $data[$item[$field]];
        }
    }

    return $array;
    
}

function extend_field_oneline( $array , $field , $table , $join = 'id' )
{
    if( !is_array( $array ) ) return $array;
    $id = $array[$field];

    if( $table == 'user' )
        $sql = "SELECT " . c('user_normal_fields') . " FROM `" . s( $table ) . "` WHERE `" . s( $join ) . "` =  " . intval($id) . "  LIMIT 1";
    else
        $sql = "SELECT * FROM `" . s( $table ) . "` WHERE `" . s( $join ) . "` = " . intval($id) . "  LIMIT 1";
    
   // echo $sql;
    
    if( $line = db()->getData( $sql )->toLine())
        $array[$field] = $line;

    return $array;
    
}



