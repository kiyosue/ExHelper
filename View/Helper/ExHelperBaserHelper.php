<?php
/**
 * ExHelperHelper
 * BcBaserHelper にたりないと思う機能を追加したもの
 *
 * @package ExHelper.View.Helper
 * @copyright		Copyright Since 2016 Kiyosue
 *
 * @property ExBlog $ExBlog
 */


class ExHelperBaserHelper extends AppHelper {

	public $helpers = array('ExHelper.ExBlog');


	/**
	 * 現在のページがブログかどうかを判定する
	 * pluginだけで良いのかもしれないけど、controllerもチェックしておく
	 * blogとの固定文字列比較を本当はやめたいけど、定数やconfigにはいってないのでしかたなく
	 * BlogHelper isSingle でも同様の比較をしてるので直すなら両方いっきになおす
	 *
	 * @return bool
	 */
	public function isBlog() {
		return (
			$this->request->params['plugin'] === 'blog' &&
			$this->request->params['controller'] === 'blog'
		);
	}


	/**
	 * 全てのブログのポストデータを取得
	 *
	 * @return array ブログデータ
	 *
	 */
	public function allBlogPosts($options = array()) {
		return $this->ExBlog->allBlogPosts($options);
	}

	/**
	 * 直前のallBlogPostsで、取得したデータに対してのpaginationを出力する
	 *
	 * @return array ページネーションのデータ
	 *
	 */
	public function allBlogPagination() {
		$this->ExBlog->allBlogPagination();
	}

	/**
	 * 直前のallBlogPostsで、取得したデータに対してのpaginationを取得する
	 *
	 * @return array ページネーションのデータ
	 *
	 */
	public function getAllBlogPagination() {
		return $this->ExBlog->getAllBlogPagination();
	}


	/**
	 * コピーライト用の年を取得する
	 *
	 * 《利用例》
	 * $this->BcBaser->getCopyYear(2012, ' ~ ')
	 *
	 * 《出力例》
	 * 2012 ~ 2014
	 *
	 * @param integer $begin 開始年
	 * @param string $delimiter 区切り文字 default ' - '
	 * @return string
	 */
	public function getCopyYear($begin, $delimiter = ' - ') {
		$year = date('Y');
		if ($begin == $year || !is_numeric($begin)) {
			return $year ;
		}

		ob_start();
		$this->BcBaser->copyYear($year);
		$copyYear = str_replace(' - ', $delimiter, ob_get_contents()) ;
		ob_end_clean();

		return $copyYear ;
	}


	// ブログ記事のURLを取得する

	// アイキャッチ画像をフルパスで返す
	// get_the_post_thumbnail
	// get_the_post_eye catch

	// htmlタグいらない

	// 固定ページで、概要を出力したくない場合があるよね。
}
