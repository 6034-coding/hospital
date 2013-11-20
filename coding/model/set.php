<?php

$g_o = empty($g_o) ? 'userlist' : $g_o;

$config['menu'] = array('用户管理' => '?m=set&o=userlist',
						'添加用户' => '?m=set&o=useradd');

$config['operate'] = array('userlist' => '用户管理','useradd' => '添加用户');

?>