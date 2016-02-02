<?php

$config['BcApp.adminNavi.helloWorld'] = array(
	'name' => 'ヘルパー拡張プラグイン',
	'contents' => array(
		array('name' => 'マニュアル表示', 'url' => array('admin' => true, 'plugin' => 'ex_helper', 'controller' => 'hello_world', 'action' => 'index')),
	)
);

