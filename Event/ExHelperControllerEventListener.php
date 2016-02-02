<?php
/**
 * Created by PhpStorm.
 * User: kiyo
 * Date: 2016/01/30
 * Time: 14:29
 */


class ExHelperControllerEventListener extends BcControllerEventListener {

	// 登録先イベントの定義
	public $events = array(
		'Blog.Blog.beforeRender',
	);

	/**
	 * 拡張BlogHelperを呼び出しに追加
	 *
	 */
	public function blogBlogBeforeRender(CakeEvent $event) {
		$path = App::pluginPath('ExHelper');

		// ヘルパーのパスを追加
		App::build(array(
			'View/Helper' => array( $path . 'View' . DS . 'Helper' . DS)
			),
			APP::APPEND
		);

		$Controller = $event->subject();
		$Controller->helpers[] = 'ExBlog';

	}


}

