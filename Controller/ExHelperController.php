<?php
/**
 * Created by PhpStorm.
 * User: kiyo
 * Date: 2016/01/30
 * Time: 14:29
 */

// BcPluginAppControllerを継承する前の準備
App::uses('BcPluginAppController', 'Controller');
App::uses('ExHelperAppController', 'ExHelper.Controller');
App::uses('BlogPost', 'Blog.Model');

class ExHelperController extends ExHelperAppController {

	public $name = 'ExHelper';

	public $uses = array('Blog.BlogPost', 'ExHelper.ExHelper');

	// 管理画面接続時にログイン認証を行う設定
	public $components = array('BcAuth', 'Cookie', 'BcAuthConfigure', 'Paginator');

	public $paginate = null;

	/**
	 * ぱんくずナビ
	 *
	 * @var string
	 */
	public $crumbs = array(
		array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
		array('name' => 'ヘルパー拡張マニュアル', 'url' => array('plugin' => 'ex_helper', 'controller' => 'ex_helper', 'action' => 'index')),
	);

	public function beforeFilter() {
		parent::beforeFilter();

		if (!preg_match('/^admin_/', $this->action)) {
			// フロント側のindexアクションの際は認証しないようにする
			$this->BcAuth->allow('index');
		} else {
			// ファイル名を指定して、サブメニューに設定する
			$this->subMenuElements = array('ex_helper');
		}
	}

	/**
	 * 管理画面用のデフォルトアクション
	 * Helpを表示して終了
	 *
	 */
	public function admin_index() {
	}


}
